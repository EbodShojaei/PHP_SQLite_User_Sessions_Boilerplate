<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$dashboardController = new DashboardController();
$selectedYear = $_SESSION['dashboard_year'] ?? date('Y'); // Use the year from session or the current year

// Fetch data for the selected year
$summaryTable = $dashboardController->generateExpenseSummaryTable($selectedYear);
$pieChartData = $dashboardController->generateExpensePieChartData($selectedYear);
?>

<div class="container my-5">
    <h1 class="my-5">Dashboard - Expense Summary for
        <?= htmlspecialchars($selectedYear); ?>
    </h1>

    <!-- Form to select year -->
    <form action="/pages/dashboard/submit/" method="post">
        <div class="form-group">
            <label for="year">Select Year:</label>
            <select class="form-control" id="year" name="year">
                <?php foreach ($dashboardController->getAvailableYears() as $year): ?>
                    <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>>
                        <?= $year ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php if (!empty($summaryTable)): ?>
        <!-- Display the expense summary table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Expense</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($summaryTable as $row): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($row['category']); ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['total_expense']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Display the expense pie chart -->
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Expenses by Category for Year <?= $selectedYear ?>"
                },
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0.00\"$\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?= json_encode($pieChartData, JSON_NUMERIC_CHECK) ?>
                }]
            });
            chart.render();
        </script>
    <?php endif; ?>
</div>