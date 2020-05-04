<?php
class DBController
{
   // private $schema = "root";
   private $database = "//localhost/xe";
   private $user = "pm2020";
   // private $password = "Test@123!";
   private $password = "admin";
   // private $charset = 'UTF8';
   private $client_info = 'Cleckhudderfax Online Megastore';
   // Apex Access
   // Workspace: TBC_PM2020
   // User: root
   // Password: admin

   /**
    * @var resource The connection resource
    * @access protected
    */
   protected $conn = null;
   /**
    * @var resource The statement resource identifier
    * @access protected
    */
   protected $stid = null;
   /**
    * @var integer The number of rows to prefetch with queries
    * @access protected
    */
   protected $prefetch = 100;

   function __construct($module, $cid)
   {
      $this->conn = oci_connect($this->user, $this->password, $this->database);
      if (!$this->conn) {
         $m = oci_error();
         throw new \Exception('Cannot connect to database: ' . $m['message']);
      }
      // Record the "name" of the web user, the client info and the module.
      // These are used for end-to-end tracing in the DB.
      oci_set_client_info($this->conn, $this->client_info);
      oci_set_module_name($this->conn, $module);
      oci_set_client_identifier($this->conn, $cid);
   }
   /**
    * @param string $sql The statement to run
    * @param string $action Action text for End-to-End Application Tracing
    * @param array $bindvars Binds. An array of (bv_name, php_variable, length)
    */
   public function execute($sql, $action, $bindvars = array())
   {
      $this->stid = oci_parse($this->conn, $sql);
      // if ($this->prefetch >= 0) {
      //    oci_set_prefetch($this->stid, $this->prefetch);
      // }
      $output = array();
      foreach ($bindvars as &$bv) {
         // oci_bind_by_name(resource, bv_name, php_variable, length)
         oci_bind_by_name($this->stid, $bv[0], $bv[1], $bv[2]);
      }
      unset($bv);

      $success = oci_execute($this->stid); // will auto commitnt_r($bindvars[0]);
      // Format output
      foreach ($bindvars as $bv) {
         $output[substr($bv[0], 1)] = $bv[1];
      }
      return array("success" => $success, "data" => $output);
   }
   /**
    * Run a query and return all rows.
    *
    * @param string $sql A query to run and return all rows
    * @param string $action Action text for End-to-End Application Tracing
    * @param array $bindvars Binds. An array of (bv_name, php_variable, length)
    * @return array An array of rows
    */
   public function execFetchAll($sql, $action, $bindvars = array())
   {
      $this->execute($sql, $action, $bindvars);
      oci_fetch_all($this->stid, $res, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);
      $this->stid = null;  // free the statement resource
      return ($res);
   }
   /**
    * Destructor closes the statement and connection
    */
   function __destruct()
   {
      if ($this->stid)
         oci_free_statement($this->stid);
      if ($this->conn)
         oci_close($this->conn);
   }
}
$db = new DBController("Test", "Dikson");
