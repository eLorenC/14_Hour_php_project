<?php

    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 2/22/2016
     * Time: 8:32 PM
     */
    require_once('DataConfiguration.php');

    class Database
    {
        protected $stmt;

        protected $pdo;

        private $debug = true;

        private $runWatchTower;


        /**
         * Database constructor.
         */
        public function __construct()
        {
            try {
                $this->pdo = new PDO("mysql:host=". \AppData\DataConfiguration::readConfig('db.host') . ";dbname=" . \AppData\DataConfiguration::readConfig('db.base'),
                    \AppData\DataConfiguration::readConfig('db.user'), \AppData\DataConfiguration::readConfig('db.pass'));

                if ($this->debug) {
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
            } catch (PDOException $e) {
                die($this->debug ? $e->getMessage() . ' ' . $e->getTraceAsString() : 'cool');
            }
        }



        /*****************************************************************************************************************************************
         *  CLASS HELPER METHODS
         *****************************************************************************************************************************************/


        // DO NOT USE FOR PRODUCTION -- USE PREPARED STATEMENTS INSTEAD
        // ******************** DEVELOPMENT ONLY ********************
        // public function query($sql)
        // {
        //    return $this->pdo->query($sql);
        // }


        public function prep($sql)
        {
            if ($this->hasDataChange($sql))
            {
                $this->runWatchTower = ($this->hasWatchTower($sql)===false)? true : false;
            }

            $this->stmt = $this->pdo->prepare($sql);
            return $this;
        }

        public function bind($param, $value, $type = null)
        {
            if (is_null($type))
            {
                switch (true)
                {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
                $this->stmt->bindValue($param, $value, $type);
            }
            else
            {
                $this->stmt->bindValue($param,$value, $type);
            }

            return $this;
        }


        public function runQuery($bind_params = null)
        {
            /**
             *  Check If runWatchTower private field is true ->
             *  If it is, run watchTowerUpdate(), which will set runWatchTower
             *  to false because it is an update AND contains 'watchtower'
             */
            try
            {
                if($this->runWatchTower===true)
                {
                    $this->watchTowerUpdate();
                }
            }
            catch (Exception $error)
            {
                var_dump($error->getMessage() . '<br><br>  watchTowerUpdate() failed');
            }

            try
            {
                if (!is_null($bind_params))
                {
                    // In the case of insert, bind params during execution by passing an associative array of values
                    return $this->stmt->execute($bind_params);
                }
                else
                {
                    $this->stmt->execute();
                }
            }
            catch (Exception $error2)
            {
                var_dump($error2->getMessage());
            }
            finally
            {
                return $this;
            }
        }


        public function count()
        {
            return $this->stmt->rowCount();
        }


        // DEFAULTS TO FETCH_ASSOC
        public function getAll($pdo_fetch_attribute = PDO::FETCH_ASSOC)
        {
            return $this->stmt->fetchAll($pdo_fetch_attribute);
        }


        public function getFirst($pdo_fetch_attribute = PDO::FETCH_ASSOC)
        {
            return $this->getAll($pdo_fetch_attribute)[0];
        }


        public function lastInsertId(){
            return $this->pdo->lastInsertId();
        }


        /*****************************************************************************************************************************************
         *  PDO TRANSACTIONS
         *****************************************************************************************************************************************/
        public function beginTransaction(){
            return $this->pdo->beginTransaction();
        }

        public function endTransaction(){
            return $this->pdo->commit();
        }

        public function cancelTransaction(){
            return $this->pdo->rollBack();
        }


        /*****************************************************************************************************************************************
         *  OTHER HELPERS
         *****************************************************************************************************************************************/

        private function hasDataChange($sql)
        {
            return ((strpos($sql,"INSERT") || strpos($sql,"UPDATE") || strpos($sql,"DELETE")));
        }

        private function hasWatchTower($sql)
        {
            return (strpos($sql, "watchtower")===1);
        }

        private function watchTowerUpdate()
        {
            $this->prep("UPDATE `watchtower` SET `ModifiedDateTime` = :value WHERE `CouncilID` = :value1");
            $this->bind(':value',date("Y-m-d H:i:s"));
            $this->bind(':value1', $_SESSION['user']['CouncilID']);
            $this->runQuery();
        }
    }