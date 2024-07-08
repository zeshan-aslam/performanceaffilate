<?php

/**

 * Database operations class (Using PDO)

 * @author Gulfam Khan

 * @copyright 2020

 */

class database_opeartions
{
    public $run = "";
    public $connection = "";
    public $baseRows   = null; 

    public function __construct()
    {
        $this->run = null;
        $this->connection = null;
    }

    public function db_connect($server_name, $user_name, $password, $sl_db)
    {
        try {
            $conn = new PDO("mysql:host=" . $server_name . ";dbname=" . $sl_db . ";charset=utf8", $user_name, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function run_query($query)
    {
        try {
            $this->run = $this->connection->prepare($query);
            $this->run->execute();
            return $this->run;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function baseSelect($_table, $_where = null)
    {
        if (!empty($_where)) {
            $_whereCondition = " WHERE " . $_where;
        }
        $mainSql = "SELECT * FROM " . PREFIX . $_table . " " . $_whereCondition . "  ";
        $this->baseRows = $this->number_rows_hide($mainSql);   
        if ($this->number_rows_hide($mainSql) == 1) {
        return $data = $this->fetch_single_row($mainSql);
        } elseif ($this->number_rows_hide($mainSql) > 1) {
            return $data = $this->fetch_all($mainSql);
        } else {
            return false;
        }
    }

    public function fetch_all($org_query, $passed_params = null)
    {
        try {
            $req_result = $this->connection->prepare($org_query);
            if (!empty($passed_params)) {
                foreach ($passed_params as $key => $value) {
                    #param type choice
                    if (gettype($value) === 'integer') {
                        $pram_type = PDO::PARAM_INT;
                    }
                    if (gettype($value) === 'string') {
                        $pram_type = PDO::PARAM_STR;
                    }

                    $req_result->bindParam(':' . $key . '', $value, $pram_type);
                }
            }

            $req_result->execute();
            return $RESULT = $req_result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function fetch_single_row($original_query, $passed_params = null)
    {
        try {
            $req_result = $this->connection->prepare($original_query);
            if (!empty($passed_params)) {
                foreach ($passed_params as $key => $value) {
                    #param type choice
                    if (gettype($value) === 'integer') {
                        $pram_type = PDO::PARAM_INT;
                    }
                    if (gettype($value) === 'string') {
                        $pram_type = PDO::PARAM_STR;
                    }

                    $req_result->bindParam(':' . $key . '', $value, $pram_type);
                }
            }
            $st = $req_result->execute();
            unset($st);
            $RESULT = $req_result->fetch(PDO::FETCH_ASSOC);
            return $RESULT;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    #this function working properly
    public function cleanData($value)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    
    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function insert_values($data, $tbl, $ack = "hide")
    {

        global $custom_fun;
        try {
            $columns = implode(", ", array_keys($data));
            $escaped_values = array_values($data);
            $values = implode("', '", $escaped_values); 
            $sql = "INSERT INTO " . PREFIX . $tbl . "(" . $columns . ")" . "VALUES('" . $values . "')";
            $check_run = $this->run_query($sql);
            if ($check_run) {
                if ($ack == "show") {
                    echo '
                                                 <div id="s_msg" style="margin-top:100px; width:400px;">

                                                 <div class="alert alert-success">
                                                 <strong>Success!</strong> Data has been Inserted Successfully.
                                                 </div>
                                                 </div>
                                                       ';
                    //$custom_fun->redirect_page($custom_fun->GET_SEP_URL());
                }
                if ($ack == "hide") {
                    //$sql;
                    return true;
                    //$custom_fun->redirect_page($custom_fun->GET_SEP_URL()."&ACK=T");
                }

            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function number_rows($un_query)
    {
        try {
            $un_query_res = $this->connection->prepare($un_query);
            $un_query_res->execute();
            $out_un_query_res = $un_query_res->rowCount();
            echo $out_un_query_res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function ins_doc_vals($data, $tbl)
    {

        $columns = implode(", ", array_keys($data));
        $escaped_values = array_map('mysql_real_escape_string', array_values($data));
        $values = implode("', '", $escaped_values);
        echo $sqldoc = "INSERT INTO " . PREFIX . $tbl . "(" . $columns . ")" . "VALUES('" . $values . "')";
        global $db;
        $check_run = $db->run_query($sqldoc);

        if ($check_run) {
            echo $sqldoc;
            echo '
                                           <div id="s_msg" style="margin-top:100px; width:400px;">

                                           <div class="alert alert-success">
                                           <strong>Success!</strong> Data has been Inserted Successfully.
                                           </div>
                                           </div>
                                                 ';
        } else {
            echo '
                                           <div id="s_msg" style="margin-top:100px; width:400px;">

                                           <div class="alert alert-error">
                                           <strong>Error!</strong> Something went wrong! Unable to Insert data.
                                           </div>
                                           </div>
                                                 ';
        }
    }

    public function number_rows_hide($un_query)
    {
        try {
            $un_query_res = $this->connection->prepare($un_query);
            $un_query_res->execute();
            $out_un_query_res = $un_query_res->rowCount();
            return $out_un_query_res;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function number_rows_hide_join($un_query)
    {
        try {

            $totalRec = $this->fetch_all($un_query);
            $totalCount = null; 
            foreach ($totalRec as $key => $valRec) {
                $totalCount++;
            }
            return $totalCount;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update_vals($data, $cons_tbl, $id)
    {
        $up_sql = 'UPDATE ' . $cons_tbl . ' SET ';
        $up_sql_pre = null;
        foreach ($data as $key => $val_data) {
            $up_sql_pre .= $key . " ='" . $val_data . "',";
        }
        $finl_SQL = $up_sql . rtrim($up_sql_pre, ',') . ' WHERE id=' . $id;
        if ($this->run_query($finl_SQL)):
            echo "Updated Successfully";
        else:
            echo "Unable to update.";
        endif;
    }

    public function update_vals_chk($data, $cons_tbl, $id)
    {
        $up_sql = 'UPDATE ' . $cons_tbl . ' SET ';
        $up_sql_pre = null;
        foreach ($data as $key => $val_data) {
            $up_sql_pre .= $key . " ='" . $val_data . "',";
        }
        echo $finl_SQL = $up_sql . rtrim($up_sql_pre, ',') . ' WHERE parent_id=' . $id;
        if ($this->run_query($finl_SQL)):
            echo "Updated Successfully.";
        else:
            echo "Unable to update.";
        endif;
    }
    public function update_values($data, $tbl, $conti = null, $params = null, $conti_field = null)
    {

        /*Parameters Reference*/
        // #1 $data      (Associative Array)
        // #2 $tbl       (table name without PREFIX)
        // #3 $conti     (id in case of not geting by $_GET) Means Contigency
        // #4 $params    (send $_GET Parameters; message parameters will be sent by default)
        // #5 $conti_field (Update against any other field then id)
        try {
            global $custom_fun, $sec;
            if ($conti_field == null) {
                $ref_field = 'id';
            }

            if ($conti_field != null) {
                $ref_field = $conti_field;
            }

            $counter = 0;
            foreach ($data as $key => $value) {
                $counter++;
                if ($counter == "1") {
                    $update_query = $update_query = "UPDATE " . PREFIX . $tbl . " SET ";
                }
                $update_query .= $key . "=" . "'" . $value . "'" . ',';
            };
            if (isset($_GET[SENTID])) {
                $final_SQL = rtrim($update_query, ',') . " WHERE " . $ref_field . " = :given_id ";
            }

            if (!isset($_GET[SENTID])) {
                $final_SQL = rtrim($update_query, ',') . " WHERE " . $ref_field . " = :given_conti";
            }

            $sql_pre = $this->connection->prepare($final_SQL);
            if (isset($_GET[SENTID])) {
                $cons_id = $sec->decode_it($_GET[SENTID]);
                $sql_pre->bindParam(':given_id', $cons_id, PDO::PARAM_INT);
            }
            if ($conti != null) {
                $sql_pre->bindParam(':given_conti', $conti, PDO::PARAM_INT);
            }
            $CONF = $sql_pre->execute();

            //echo $final_final_SQL = mysql_real_escape_string($final_SQL);

            if ($CONF) {
                #Hide in case of using .htaccess
                $ref_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . basename($_SERVER['PHP_SELF']) . "?" . $params . "&ACKT=1";

                # Make this portion as comments, When you are not using .htaccess
                # It works without complexties in .php extension but create problem with .htaccess so all modification for handling .htaccess problems
                /*$ht_base = substr(basename($_SERVER['PHP_SELF']), 0, -4)."/";
                if(isset($_GET['ACKT']) OR !empty($params)){
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $link_wo_get = $custom_fun->remove_get($actual_link,"&ACKT");
                $ref_link  = $link_wo_get.$params."&ACKT=1";
                }
                else{
                $ref_link  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/".$ht_base."?".$params."&ACKT=1";
                }*/

                $custom_fun->redirect_page($ref_link);
                #Switch on in case of not working
                //echo $final_SQL;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $final_SQL;
            #Hide in case of using .htaccess
            $ref_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . basename($_SERVER['PHP_SELF']) . "?" . $params . "&ACKF=0";

            #Make Comment when your'nt using .htaccess
            /*$ht_base = substr(basename($_SERVER['PHP_SELF']), 0, -4)."/";
        $ref_link  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/".$ht_base."?".$params."&ACKF=0";
        $custom_fun->redirect_page($ref_link);*/
        }
    }

    public function update_values_wor($data, $tbl, $conti = null, $params = null, $conti_field = null)
    {

        /*Parameters Reference*/
        // #1 $data      (Associative Array)
        // #2 $tbl       (table name without PREFIX)
        // #3 $conti     (id in case of not geting by $_GET) Means Contigency
        // #4 $params    (send $_GET Parameters; message parameters will be sent by default)
        // #5 $conti_field (Update against any other field then id)
        try {
            global $custom_fun, $sec;
            if ($conti_field == null) {
                $ref_field = 'id';
            }

            if ($conti_field != null) {
                $ref_field = $conti_field;
            }

            $counter = 0;
            foreach ($data as $key => $value) {
                $counter++;
                if ($counter == "1") {
                    $update_query = $update_query = "UPDATE " . PREFIX . $tbl . " SET ";
                }
                $update_query .= $key . "=" . "'" . $value . "'" . ',';
            };
            if (isset($_GET[SENTID])) {
                $final_SQL = rtrim($update_query, ',') . " WHERE " . $ref_field . " = :given_id ";
            }

            if (!isset($_GET[SENTID])) {
                $final_SQL = rtrim($update_query, ',') . " WHERE " . $ref_field . " = :given_conti";
            }

            $sql_pre = $this->connection->prepare($final_SQL);
            if (isset($_GET[SENTID])) {
                $cons_id = $sec->decode_it($_GET[SENTID]);
                $sql_pre->bindParam(':given_id', $cons_id, PDO::PARAM_INT);
            }
            if ($conti != null) {
                $sql_pre->bindParam(':given_conti', $conti, PDO::PARAM_INT);
            }
            $CONF = $sql_pre->execute();
            //echo $final_final_SQL;
            //echo $final_final_SQL = mysql_real_escape_string($final_SQL);

            if ($CONF) {
                #Hide in case of using .htaccess
                $ref_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . basename($_SERVER['PHP_SELF']) . "?" . $params . "&ACKT=1";

                /*
                $ht_base = substr(basename($_SERVER['PHP_SELF']), 0, -4)."/";
                # Make this portion as comments, When you are not using .htaccess
                # It works without complexties in .php extension but create problem with .htaccess so all modification for handling .htaccess problems
                if(isset($_GET['ACKT']) OR !empty($params)){
                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $link_wo_get = $custom_fun->remove_get($actual_link,"&ACKT");
                $ref_link  = $link_wo_get.$params."&ACKT=1";
                }
                else{
                $ref_link  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/".$ht_base."?".$params."&ACKT=1";
                }*/

                //$custom_fun->redirect_page($ref_link);
                //echo $final_SQL;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $final_SQL;
            #Hide in case of using .htaccess
            $ref_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/" . basename($_SERVER['PHP_SELF']) . "?" . $params . "&ACKF=0";

            #Make Comment when your'nt using .htaccess
            /*$ht_base = substr(basename($_SERVER['PHP_SELF']), 0, -4)."/";
        $ref_link  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/".$ht_base."?".$params."&ACKF=0";
        $custom_fun->redirect_page($ref_link);*/
        }
    }

    public function get_cols($db_name, $table_name)
    {

        try {
            global $db;
            $ret_res = array();
            $fetch_cols =
                "
            SELECT `COLUMN_NAME`
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_SCHEMA`='" . $db_name . "'
            AND   `TABLE_NAME`  ='" . PREFIX . $table_name . "'";
            $run = $this->connection->query($fetch_cols);
            return $RESULT = $run->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function last_ins_id()
    {
        return $this->connection->lastInsertId();
    }


    public function find_duplicates($fields, $table, $whr)
    {
        global $sec;
        $find_dup_sql = "SELECT " . $fields . " FROM " . PREFIX . "" . $table . " WHERE " . $whr . " ";
        if ($this->number_rows_hide($find_dup_sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function csv_import($file_from, $table)
    {
        global $custom_fun;
        /*Fetch Table Field names*/
        $specific_table_cols_sql = "SHOW COLUMNS FROM " . PREFIX . $table . " ";
        $specific_table_cols = $this->fetch_all($specific_table_cols_sql);
        foreach ($specific_table_cols as $key => $col_name) {
            $final_cols_name[] = $col_name['Field'];
        }

        $filename = $_FILES[$file_from]['tmp_name'];
        $flag = true;
        $file = fopen($filename, "r");
        $col_length = count($final_cols_name);
        while (($getData = fgetcsv($file, 10000, ",")) !== false) {
            if ($flag) {$flag = false;
                continue;}
            for ($i = 0; $i < $col_length; $i++) {
                $tableData[$final_cols_name[$i]] = $getData[$i];
            }

            if (self::insert_values($tableData, $table, "hide")) {
                $ACK = true;
            } else {
                $ACK = false;
            }

        }

        if ($ACK) {
            $custom_fun->show_ack(SUCCESS, 1);
        } else {
            $custom_fun->show_ack(ERROR, 0);
        }

        fclose($file);

    }

    public function csv_export($table)
    {

        global $db;
        $specific_table_cols_sql = "SHOW COLUMNS FROM " . PREFIX . $table . " ";
        $specific_table_cols = $this->fetch_all($specific_table_cols_sql);
        foreach ($specific_table_cols as $key => $col_name) {
            $final_cols_name[] = $col_name['Field'];
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, $final_cols_name);
        $csv_sql = "SELECT * FROM " . PREFIX . $table . " ORDER BY id";
        $all_records = self::fetch_all($csv_sql);
        foreach ($all_records as $key => $value_csv) {
            fputcsv($output, $value_csv);
        }
        fclose($output);
    }

    public function make_sel_ops($tbl_nme, $fieldI, $fieldII, $whr = null, $ex_val = null)
    {
        global $db;

        if ($ex_val != null):
            $prev_val = $ex_val;
        else:
            $prev_val = $fieldI;
        endif;

        if ($whr != null):
            $WHERE_CONDITION = $whr;
        else:
            $WHERE_CONDITION = null;
        endif;

        $request_fet_SQL = "SELECT " . $fieldI . ", " . $fieldII . " FROM " . PREFIX . "" . $tbl_nme . " " . $WHERE_CONDITION . " ";
        $request_fetched = $db->fetch_all($request_fet_SQL);

        foreach ($request_fetched as $key => $value_request_fetched) {
            echo '<option value="' . $value_request_fetched[$fieldI] . '"';
            if ($prev_val == $value_request_fetched[$fieldI]) {
                echo "selected";
            }
            echo '>' . $value_request_fetched[$fieldII] . '</option>';
        }
    }

    public function getJson($_table, $_where = null)
    {
        if (!empty($_where)) {
            $_whereCondition = " WHERE " . $_where;
        }
        $mainSql = "SELECT * FROM " . PREFIX . $_table . " " . $_whereCondition . "  ";
        if ($this->number_rows_hide($mainSql) == 1) {
            $data = $this->fetch_single_row($mainSql);
            return  $dataToRet = json_encode($data);
        } elseif ($this->number_rows_hide($mainSql) > 1) {
            $data = $this->fetch_all($mainSql);
            return $dataToRet = json_encode($data);
        } else {
            return false;
        }   
    }

} //End class
