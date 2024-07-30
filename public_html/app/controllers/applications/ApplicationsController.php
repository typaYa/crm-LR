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
        if ($_SESSION['user_role']==2){
            $allApplications=$this->applications->selectAllApplicationForCallCenter($_SESSION['call_center']);
            $selectAllUserForCallCenter = $this->applications->selectAllUserForCallCenter($_SESSION['call_center']);

            include 'app/views/apllications/showForCallCenter.php';
        }else if($_SESSION['user_role']==1){
            $allApplications=$this->applications->selectAllApplicationForCallCenterUser($_SESSION['call_center'],$_SESSION['user_id']);
            include 'app/views/apllications/showForCallCenterUser.php';
        }
        else{
            $data = $this->applications->selectAllApplication();
            $allApplications = $data[0];
            $pagination = $data[1];
            include 'app/views/apllications/index.php';
        }


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
    public function search($data)
    {
        $selectedApplicationsForSearch = $this->applications->searchApplication($data);
        include 'app/views/apllications/search.php';
    }
    public function showNumber($number){
        $selectedInfoForNumber = $this->applications->selectedInfoForNumber($number);
        include 'app/views/apllications/showNumber.php';
    }
    public function showLeadForNumber($number)
    {
        $allApplications=$this->applications->showLeadForNumber($number);
        include 'app/views/apllications/showLeadsForNumber.php';
    }
    public function selectHistoryUpdateApplications()
    {
        $selectHistoryUpdateApplications = $this->applications->selectHistoryUpdateApplications();
        include 'app/views/apllications/showHistoryUpdateApplications.php';
    }
    public function searchForHistory($data)
    {
        $selectHistoryUpdateApplications = $this->applications->selectHistoryUpdateForData($data);
        include 'app/views/apllications/showHistoryUpdateApplications.php';
    }
    public function sendOnCallCenter($data)
    {
        $this->applications->sendOnCallCenter($data);
        header('Location:index.php?page=applications');
    }

    public function sendOnCallCenterUser($data)
    {
        $this->applications->sendOnCallCenterUser($data);
        header('Location:index.php?page=applications');
    }




}