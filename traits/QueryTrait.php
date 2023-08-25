<?php

namespace traits;

use models\Database;
use models\Album;
use models\Artist;
use models\Genre;
use models\Song;
use models\Playlist;

  /**
   * QueryTrait provides useful functions that can be used by several models to fetch data from the database.
   * Models can obtain object arrays, counts, or single records from the database. 
   * Reduces code duplication between models.
   */

trait QueryTrait {

    public static function getObjectArray ($tableName) {
        if (self::canCheckTable($tableName)) {
            
            $className = "models\\" . self::getClassNameFromTableName($tableName);

            if(class_exists($className)){
                $objects = array();
                // Query to get all records of the relevant type from the database
                $query = "SELECT * FROM $tableName ORDER BY id ASC";
                $stmt = Database::getInstance()->getConnection()->prepare($query);
                $stmt->execute();

                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    // Create Song objects and store them in the $songs array
                    $objects[] = new $className($row['id']);
                }

                $stmt->close();

                return $objects;
            } 
            
        }
        return [];
    }

    public static function getCount ($tableName) {
        if(self::canCheckTable($tableName)){
            //Query to get the count of all rows in the specified table.
            $query = "SELECT COUNT(id) AS count FROM $tableName";

            $stmt = Database::getInstance()->getConnection()->prepare($query);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $stmt->close();

            return $count;
        }
        return 0;
        
    }

    public function getSingle () {
        return 0; 
    }

    public static function canCheckTable ($tableName){
        //$tableName must match one of table names hardcoded in modifiable array! 
        $modifiable = ['albums', 'artists', 'genres', 'playlists', 'playlistsongs', 'songs'];
        if(in_array($tableName, $modifiable)){
            return true;
        }
        return false;
    }

    private static function getClassNameFromTableName($tableName) {
        // Convert table name to singular and capitalize, e.g. 'songs' to 'Song'
        return ucfirst(substr($tableName, 0, -1));
    }
 }
