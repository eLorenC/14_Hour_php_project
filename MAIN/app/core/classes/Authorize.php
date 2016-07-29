<?php

    /**
     * Created by PhpStorm.
     * User: ericl_000
     * Date: 2/22/2016
     * Time: 8:33 PM
     */
    class Authorize
    {
        protected $database;

        protected $hash;

        protected $session = 'Shopper';

        public $result;


        public function __construct(Database $database, Hash $hash)
        {
            $this->database = $database;
            $this->hash = $hash;
        }

        // Authenticate user, update user table data, create 'user' index within the session, store 'user' data in session.
        public function signin($data)
        {
            try {
                // Set $user equal to the return of calling 'where' function on this database object.
                // -- Where database user is equal to username entered in field.
                $user = $this->database->prep("SELECT * FROM `useracct` WHERE `UserName` = :username")->bind(':username', $data['UserName'])->runQuery();

                //var_dump($user);
                // If user exists in system
                if ($user->count()) {
                    // DEV ONLY
                    // var_dump($user->first());
                    // $user = first (only) instance of user
                    //$user = $user->first();
                    $user = $user->getFirst(PDO::FETCH_ASSOC);

                    // DEV ONLY
                    // var_dump($this->formatUser($user));

                    // If the password entered in field ($data['password']) is verified (against the stored hash) --
                    // set the userAuthSession, passing in the verified user's id --
                    // then return true

                    // DEV ONLY
                    //var_dump($this->hash->hashCheck($data['AcctPass'], $user->AcctPass));
                    if ($this->hash->hashCheck($data['Password'], $user["Password"])) {
                        $this->setAuthSession($user);

                        // DEV ONLY
                        // var_dump($user);
                        return true;
                    }
                }
            }
            catch (Exception $error)
            {
                //var_dump($error->getMessage());
            }
            // If user does not exist in database return false.
            return false;
        }



        public function signout()
        {
            $_SESSION = array();
            return;
        }


        public function check()
        {
            return isset($_SESSION[$this->session]);
        }


        /**
         * @param $user
         */
        protected function setAuthSession($user)
        {
            // Change this to specific user values -- DONE -- See formatUser() **REVISED**
            $_SESSION[$this->session] = $user;
        }


        private function setSessionRole()
        {
            $_SESSION[$this->session]['Role'] = $this->getUserRole($_SESSION[$this->session]['AcctID']);
        }


        public function updateSessionTime()
        {
            $_SESSION[$this->session]['LastUpdate'] = date("Y-m-d H:i:s");
        }


        public function setUserStatus($status)
        {
            try
            {
                $this->database->prep("UPDATE `useracct` SET `IsOnline` = :value_num WHERE `useracct`.`AcctID` = :value");
                $this->database->bind(':value_num',$status)->bind(':value', $_SESSION[$this->session]['AcctID'])->runQuery();
            }
            catch (PDOException $pdoerror)
            {
                var_dump($pdoerror->getMessage());
            }
        }


        public function getSessionTime()
        {
            return $_SESSION[$this->session]['LastUpdate'];
        }


        public function getUserInfo($access = null, $format = false)
        {
            $info = 'default';

            if($this->check())
            {
                $info = (is_null($access)) ? $_SESSION[$this->session] : $_SESSION[$this->session][ucfirst($access)];
            }
            return $info;
        }


//        public function getCouncilInfo($access = null)
//        {
//            $info = 'default';
//            if($this->check())
//            {
//                $info = (is_null($access)) ? $_SESSION[$this->session]['CouncilData'] : $_SESSION[$this->session]['CouncilData'][$access];
//
//            }
//            return $info;
//        }


        public function getUserRole($id)
        {
            try
            {
                $this->database->prep("SELECT `useracct`.`RoleID`
                                       FROM `useracct`
                                       WHERE `useracct`.`AcctID` = :value");

                $this->database->bind(':value', $id);
                $temp = $this->database->runQuery()->getFirst();
                return $temp['RoleID'];
            }
            catch (PDOException $pdoerror)
            {
                var_dump($pdoerror->getMessage());
            }
            return 'Default';
        }


        public function createUserAccount($data)
        {
            $success = false;

            try
            {
                // Grab array keys from $data -- Used to build fields and placeholders
                $keys = array_keys($data);

                //Generate fields and placeholders
                $fields       = '`' . implode('`, `', $keys) . '`';
                $placeholders = ':' . implode(', :', $keys);

                // Grab password from $data array and hash it with blowfish
                if (isset($data['Password'])) {
                    $data['Password'] = $this->hash->hashIt($data['Password']);
                }

                // Prepare insert and bind values within execution method 'runQuery'
                $this->database->prep("INSERT INTO `useracct`({$fields}) VALUES ({$placeholders})");
                $success = $this->database->runQuery($data);

                return $success;
            }
            catch (Exception $error)
            {
                var_dump($error->getMessage());
            }
            return false;
        }


        public function createUserRole($username,$data)
        {
            $success = false;

            try
            {
                $data['AcctID'] = $this->database->prep("SELECT `AcctID` FROM `useracct` WHERE `UserName` = :value");
                $this->database->bind(':value',$username);
                $this->database->runQuery();
                $this->database->getFirst(PDO::FETCH_OBJ)->AcctID;

                if (isset($data['AcctID']))
                {
                    $this->database->prep("INSERT INTO `userrole`(`AcctID`,`CouncilID`,`RoleID`)
                                           VALUES(:value1, :value2, :value3)");
                    $this->database->bind(':value1',$data['AcctID']);
                    $this->database->bind(':value2',$data['CouncilID']);
                    $this->database->bind(':value3',$data['RoleID']);

                    try
                    {
                        $success = $this->database->runQuery();
                    }
                    catch(PDOException $pdoerror)
                    {
                        // DEV ONLY
                        //var_dump($pdoerror->getMessage());
                    }
                }
                else
                {
                    throw new Exception("AcctID was not retrieved");
                }
            }
            catch (Exception $error)
            {
                var_dump($error->getMessage());
            }

            return $success;
        }


        /****************************************************************************************************************************
         *
         ****************************************************************************************************************************/

        // Format array to be stored in $_SESSION['user'].  Really just want to avoid storing the password hash -> advise please
        protected function initCouncilData()
        {
            $this->database->prep("SELECT * FROM `citycouncil` WHERE `CouncilID` = :value");
            $this->database->bind(":value", $_SESSION[$this->session]['CouncilID']);
            $temp = $this->database->runQuery()->getFirst();

            $_SESSION[$this->session]['CouncilData'] = $temp;
        }

        public function initCouncilUsers()
        {
            $this->database->prep("SELECT `ua`.`AcctID`,`ua`.`UserName`,`ua`.`FName`,`ua`.`LName`,`ua`.`EMail`,`ua`.`RoleID`
                                   FROM `useracct` AS `ua`
                                   WHERE `CouncilID` = :value1
                                   AND `UserName` <> :value2
                                   AND (`RoleID` = 3 OR `RoleID` = 4 )");
            $this->database->bind(':value1', $_SESSION[$this->session]['CouncilID']);
            $this->database->bind(':value2', $_SESSION[$this->session]['UserName']);
            $temp = $this->database->runQuery()->getAll();

            $_SESSION[$this->session]['CouncilUsers'] = array();

            foreach($temp as $n)
            {
                $_SESSION[$this->session]['CouncilUsers'][] = $n;
            }
        }


        private function formatUser($user)
        {
            return array(
                'AcctID'    => $user->AcctID,
                'FName'     => $user->FName,
                'LName'     => $user->LName,
                'EMail'     => $user->EMail,
                'UserName'  => $user->UserName
            );

        }





    }