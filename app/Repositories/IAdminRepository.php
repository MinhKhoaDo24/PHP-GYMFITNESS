<?php
namespace App\Repositories;

interface IAdminRepository
{
    /* Authentication */
    public function signIn($data);
    public function logOut();

    /* Product */
    public function searchProduct($data);

    /* Dashboard Simple Stats */
    public function getOrderView();
    public function totalsCustomer();
    public function totalsOrders();
    public function totalsMoney();
    public function totalsSaleProducts();

    /* Dashboard Analytics */
    public function getRevenue($start, $end);
    public function getOrders($start, $end);
    public function getCustomers($start, $end);
    public function getSoldProducts($start, $end);

    /* Main dashboard compiled data */
    public function getDashboardData($range);
}
