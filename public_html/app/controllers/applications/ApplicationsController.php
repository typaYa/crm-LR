<?php


class ApplicationsController
{

    protected $pdo;
    protected $applications;

    /**
     *
     */
    public function __construct()
    {
        $this->pdo=\Database::getInstance()->getConnection();
        $this->applications = new Application();
    }
    public function allApplications()
    {

        $allApplications = $this->applications->selectAllApplication();
        include 'app/views/apllications/index.php';

    }

    public function editApplication($id)
    {
        $application= $this->applications->selectApplicationForID($id);
        include 'app/views/apllications/editApplication.php';
    }
    public function updateApplication($id,$data)
    {
        $this->applications->updateApplicationForID($id,$data);
        $application= $this->applications->selectApplicationForID($id);
        $confirm = "<script>alert('Запись изменена')</script>";
        include 'app/views/apllications/editApplication.php';

    }


}