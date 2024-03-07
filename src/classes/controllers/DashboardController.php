<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

class DashboardController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function generateExpenseSummaryTable($year)
    {
        $SQL_query = "SELECT
            CASE
                WHEN b.category IS NULL THEN 'Other'
                ELSE b.category
            END AS category,
            COALESCE(SUM(t.expense), 0) AS total_expense
            FROM transactions t
            LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'
            WHERE strftime('%Y', t.date) = :year
            GROUP BY category
            ORDER BY total_expense DESC";

        $results = $this->db->query($SQL_query, [':year' => $year]);

        return $results; // Return the results instead of echoing
    }

    public function generateExpensePieChartData($year)
    {
        $SQL_query = "SELECT
            CASE
                WHEN b.category IS NULL THEN 'Other'
                ELSE b.category
            END AS category,
            COALESCE(SUM(t.expense), 0) AS total_expense
            FROM transactions t
            LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'
            WHERE strftime('%Y', t.date) = :year
            GROUP BY category
            ORDER BY total_expense DESC";

        $results = $this->db->query($SQL_query, [':year' => $year]);
        $dataPoints = [];
        foreach ($results as $row) {
            $dataPoints[] = array("label" => $row['category'], "y" => $row['total_expense']);
        }

        return $dataPoints; // Return the data points
    }

    public function getAvailableYears()
    {
        $result = $this->db->query("SELECT DISTINCT strftime('%Y', date) as year FROM transactions ORDER BY year");
        $years = array();
        foreach ($result as $row) {
            $years[] = $row['year'];
        }
        return $years;
    }
}
