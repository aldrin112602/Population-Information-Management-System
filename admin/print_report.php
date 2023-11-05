<?php 
    require_once '../config.php';
    require_once '../global.php';

    if(isset($_SESSION['role'])) {
        if($_SESSION['role'] == 'super_admin') {
            header('location: ../super_admin');
        } else {
            // header('location: /admin');
        }
    } else {
        header('location: ../index.php');
    }

    $barangay = $_GET[ 'barangay' ] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Print report - PIMS | Population Information Monitoring System</title>
    <link rel="stylesheet" href="../src/bootstrap.min.css" />
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />

    <!-- For mobile devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/pims logo.png" />
    <meta name="msapplication-TileImage" content="img/pims logo.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />

    <!-- Poppins font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- google icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">

    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        transition: all 0.5s;
    }

    main.hidden {
        display: none;
    }

    @import url('https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Spectral&display=swap');

    .dd {
        font-family: 'Lobster Two', sans-serif;
        font-size: 30px;
    }

    .cc {
        font-family: 'Spectral', serif;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <main class="px-5">

        <div class="table-responsive mt-3 px-md-5">
            <p class="text-center fs-5">
                Republic of the Philippines <br>
                Province of <?php echo $_SESSION['province'] ?> <br>
                Municipality of <?php echo $_SESSION['municipality'] ?> <br>
                <span class="fw-bold dd">Barangay <?php echo $_SESSION['barangay'] ?></span><br>
                -ooOoo-
            </p>
            <h3 class="text-center fw-bold"><i>OFFICE OF THE PUNONG BARANGAY</i></h3>
            <hr style="padding: 2px; background-color: #000;">
            <h3 class="text-center text-decoration-underline cc">CONSOLIDATION OF FAMILY PROFILE</h3>
            <h5 class="text-center">As of <?php echo date('F, Y', strtotime('2023-12-01')) ?></h5>
            <br>
            <h5>Barangay: <b><?php echo $_SESSION[ 'barangay' ] ?? '' ?></b></h5>
            <h5>No of Purok: <b><?php 
            $query = "
                SELECT COUNT(*) AS purok_count
                FROM (
                    SELECT DISTINCT purok FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION
                    SELECT DISTINCT purok FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION
                    SELECT DISTINCT purok FROM survey_form_records_household_member WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION
                    SELECT DISTINCT purok FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}'
                ) AS distinct_purok
            ";

            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $purokCount = $row['purok_count'];

            echo $purokCount;
            ?></b></h5>

            <table border="0">
                <tr>
                    <td width="300">
                        Total # OF <b>FAMILIES</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo getCount( 'survey_form_records_husband', $barangay ) ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        Total # OF <b>HOUSEHOLD</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo getCount( 'survey_form_records_husband', $barangay ) ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        Total # OF <b>MALE</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php   
                            $query = "
                                SELECT COUNT(*) AS male_count
                                FROM (
                                    SELECT sex FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Male'
                                    UNION ALL
                                    SELECT sex FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Male'
                                    UNION ALL
                                    SELECT sex FROM survey_form_records_household_member WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Male'
                                ) AS count_sex

                            ";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['male_count'];
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        Total # OF <b>FEMALE</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php   
                            $query = "
                                SELECT COUNT(*) AS female_count
                                FROM (
                                    SELECT sex FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Female'
                                    UNION ALL
                                    SELECT sex FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Female'
                                    UNION ALL
                                    SELECT sex FROM survey_form_records_household_member WHERE unique_id = '{$_SESSION['unique_id']}' AND sex = 'Female'
                                ) AS count_sex

                            ";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            echo $row['female_count'];
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        Total # OF <b>POPULATION</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp; <?php echo getPopulation( $barangay ) ?>
                        </b>
                    </td>
                </tr>
            </table>

            <h3 class="mt-4 fs-5">&gt; Civil Status of the Couple or Household Owner</h3>
            <table border="0">
                <tr>
                    <td width="300">
                        <b>MARRIED</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND status = 'Married'", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>SINGLE</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND status = 'Single'", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>WIDOW</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND status = 'Widow'", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>LIVE-IN</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND status = 'Live-in'", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>SEPARATED</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND status = 'Separated'", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>

            </table>





            <h3 class="mt-4 fs-5">&gt; Educational Attainment</h3>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col fw-bold" style="font-size: 14px;">PUROK</th>
                        <th scope="col fw-bold" style="font-size: 14px;">NO SCHOOLING</th>
                        <th scope="col fw-bold" style="font-size: 14px;">ELEMENTARY SCHOOL</th>
                        <th scope="col fw-bold" style="font-size: 14px;">HIGH SCHOOL</th>
                        <th scope="col fw-bold" style="font-size: 14px;">VOCATIONAL SCHOOL</th>
                        <th scope="col fw-bold" style="font-size: 14px;">SOME COLLEGE</th>
                        <th scope="col fw-bold" style="font-size: 14px;">ASSOCIATE DEGREE</th>
                        <th scope="col fw-bold" style="font-size: 14px;">BACHELOR'S DEGREE</th>
                        <th scope="col fw-bold" style="font-size: 14px;">MASTERS DEGREE</th>
                        <th scope="col fw-bold" style="font-size: 14px;">DOCTORAL DEGREE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $educ_att = ['no-schooling', 'elementary-school', 'high-school', 'vocational-school', 'some-college', 'associate-degree', 'bachelor-degree', 'master-degree', 'doctoral-degree'];

                for ($i = 0; $i < 6; $i++) {
                    $unique_id = $_SESSION['unique_id'];
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <?php
                        $pr = $i + 1;
                        foreach($educ_att as $att) {

                            $sqlQuery = "SELECT
                                        COUNT(*) AS total_count
                                    FROM
                                    (
                                        SELECT unique_id FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}' AND purok = $pr AND educationalAttainment = '$att'
                                        UNION ALL
                                        SELECT unique_id FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}' AND purok = $pr AND educationalAttainment = '$att'
                                        UNION ALL
                                        SELECT unique_id FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}' AND purok = $pr AND educationalAttainment = '$att'
                                        UNION ALL
                                        SELECT unique_id FROM survey_form_records_household_member WHERE unique_id = '{$_SESSION['unique_id']}' AND purok = $pr AND educationalAttainment = '$att'
                                    ) AS subquery";

                        $result = mysqli_query($conn, $sqlQuery);
                        $row = mysqli_fetch_assoc($result);
                        echo '<td>' . $row['total_count'] . '</td>';

                        }

                        ?>
                </tr>
                    <?php
                }
                ?>


                </tbody>

            </table>

            <h3 class="mt-4 fs-5">&gt; Occupation of Couple and Children</h3>
            <?php 
                $sql = "SELECT DISTINCT occupation FROM ( 
                    SELECT DISTINCT occupation FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT occupation FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT occupation FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}' ) AS distinct_occupation";
                
                $result = mysqli_query($conn, $sql);
            ?>

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col fw-bold">OCCUPATION</th>
                        <th scope="col fw-bold">HUSBAND</th>
                        <th scope="col fw-bold">WIFE</th>
                        <th scope="col fw-bold">CHILDREN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $occupation = $row['occupation'];
                        $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

                        $queryHusbandWife = "SELECT source, COUNT(occupation) as count FROM (
                            SELECT 'Husband' as source, occupation FROM survey_form_records_husband WHERE unique_id = '$unique_id' AND occupation = '$occupation'
                            UNION ALL
                            SELECT 'Wife' as source, occupation FROM survey_form_records_wife WHERE unique_id = '$unique_id' AND occupation = '$occupation'
                            UNION ALL
                            SELECT 'Children' as source, occupation FROM survey_form_records_children WHERE unique_id = '$unique_id' AND occupation = '$occupation'
                        ) AS combined_occupation_counts GROUP BY source";

                        $resultHusbandWife = mysqli_query($conn, $queryHusbandWife);

                        $counts = array();
                        while ($countRow = mysqli_fetch_assoc($resultHusbandWife)) {
                            $counts[$countRow['source']] = $countRow['count'];
                        }

                        ?>
                    <tr>
                        <td>
                            <?php echo $occupation; ?>
                        </td>
                        <td>
                            <?php echo isset($counts['Husband']) ? $counts['Husband'] : 0; ?>
                        </td>
                        <td>
                            <?php echo isset($counts['Wife']) ? $counts['Wife'] : 0; ?>
                        </td>
                        <td>
                            <?php echo isset($counts['Children']) ? $counts['Children'] : 0; ?>
                        </td>
                    </tr>
                    <?php
                    }
                ?>
                </tbody>

            </table>

            

            <h3 class="mt-4 fs-5">&gt; Place of Work of the Couple and Single <br>
                <span class="text-decoration-underline ml-5 pl-5">WITHIN THE PHILIPPINES</span>
            </h3>

            <table border="0">
                <tr>
                    <td width="300">
                        <b>Husband</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND occupation NOT IN ('', 'NA', 'na', 'n/a', 'n/a', 'N/a')", "survey_form_records_husband");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>Wife</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND occupation NOT IN ('', 'NA', 'na', 'n/a', 'n/a', 'N/a')", "survey_form_records_wife");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>Children</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                            $rows = getRows("unique_id = '{$_SESSION['unique_id']}' AND occupation NOT IN ('', 'NA', 'na', 'n/a', 'n/a', 'N/a')", "survey_form_records_children");
                            echo count( $rows );
                            ?>
                        </b>
                    </td>
                </tr>
            </table>
            <span class="text-decoration-underline ml-5 pl-5 fs-5">ABROAD</span>
            <table border="0">
                <tr>
                    <td width="300">
                        <b>Husband</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;0
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>Wife</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;0
                        </b>
                    </td>
                </tr>
                <tr>
                    <td width="300">
                        <b>Children</b>
                    </td>
                    <td width="200">
                        <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;0
                        </b>
                    </td>
                </tr>
            </table>


            <h3 class="mt-4 fs-5">&gt;Religion of the Couple and Single</h3>
            <?php 
                $sql = "SELECT DISTINCT religion FROM ( 
                    SELECT DISTINCT religion FROM survey_form_records_children WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT religion FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}'
                    UNION SELECT DISTINCT religion FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}' ) AS distinct_religion";
                
                $result = mysqli_query($conn, $sql);
                
            
            ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col fw-bold">RELIGION</th>
                        <th scope="col fw-bold">COUPLE</th>
                        <th scope="col fw-bold">SINGLE CHILDREN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $religion = $row['religion'];
                        $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

                    $queryHusbandWife = "SELECT source, COUNT(religion) as count FROM (
                        SELECT 'Husband/Wife' as source, religion FROM survey_form_records_husband WHERE unique_id = '$unique_id' AND religion = '$religion'
                        UNION ALL
                        SELECT 'Husband/Wife' as source, religion FROM survey_form_records_wife WHERE unique_id = '$unique_id' AND religion = '$religion'
                        UNION ALL
                        SELECT 'Children' as source, religion FROM survey_form_records_children WHERE unique_id = '$unique_id' AND religion = '$religion'
                    ) AS combined_religion_counts GROUP BY source";

                        $resultHusbandWife = mysqli_query($conn, $queryHusbandWife);

                        $counts = array();
                        while ($countRow = mysqli_fetch_assoc($resultHusbandWife)) {
                            $counts[$countRow['source']] = $countRow['count'];
                        }

                        ?>
                    <tr>
                        <td>
                            <?php echo $religion; ?>
                        </td>
                        <td>
                            <?php echo isset($counts['Husband/Wife']) ? $counts['Husband/Wife'] : 0; ?>
                        </td>
                        <td>
                            <?php echo isset($counts['Children']) ? $counts['Children'] : 0; ?>
                        </td>
                    </tr>
                    <?php
                    }
                ?>
                </tbody>

            </table>



            <h3 class="mt-4 fs-5 fw-bold">&gt; Ethnic Group<br>
                    <span class="text-decoration-underline ml-5 pl-5">HUSBAND</span>
            </h3>
            <?php 
                $sql = "SELECT DISTINCT ethnicGroup FROM ( 
                    SELECT DISTINCT ethnicGroup FROM survey_form_records_husband WHERE unique_id = '{$_SESSION['unique_id']}') AS distinct_ethnicGroup";
                
                $result = mysqli_query($conn, $sql);
                
            
            ?>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ethnicGroup = $row['ethnicGroup'];
                        $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

                        $queryHusbandWife = "SELECT source, COUNT(ethnicGroup) as count FROM (
                        SELECT 'ethnicGroup' as source, ethnicGroup FROM survey_form_records_husband WHERE unique_id = '$unique_id' AND ethnicGroup = '$ethnicGroup'
                    ) AS combined_ethnicGroup_counts GROUP BY source";

                        $resultHusbandWife = mysqli_query($conn, $queryHusbandWife);

                        $counts = array();
                        while ($countRow = mysqli_fetch_assoc($resultHusbandWife)) {
                            $counts[$countRow['source']] = $countRow['count'];
                        }

                        ?>
                    <tr>
                        <td>
                            <?php echo $ethnicGroup; ?>
                        </td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo isset($counts['ethnicGroup']) ? $counts['ethnicGroup'] : 0; ?>
                        </b>
                        </td>
                        
                    </tr>
                    <?php
                    }
                ?>
                </tbody>

            </table>


            <h3 class="mt-4 fs-5 fw-bold">
                    <span class="text-decoration-underline ml-5 pl-5">WIFE</span>
            </h3>
            <?php 
                $sql = "SELECT DISTINCT ethnicGroup FROM ( 
                    SELECT DISTINCT ethnicGroup FROM survey_form_records_wife WHERE unique_id = '{$_SESSION['unique_id']}') AS distinct_ethnicGroup";
                
                $result = mysqli_query($conn, $sql);
                
            
            ?>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ethnicGroup = $row['ethnicGroup'];
                        $unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

                        $queryWifeWife = "SELECT source, COUNT(ethnicGroup) as count FROM (
                        SELECT 'ethnicGroup' as source, ethnicGroup FROM survey_form_records_wife WHERE unique_id = '$unique_id' AND ethnicGroup = '$ethnicGroup'
                    ) AS combined_ethnicGroup_counts GROUP BY source";

                        $resultWifeWife = mysqli_query($conn, $queryWifeWife);

                        $counts = array();
                        while ($countRow = mysqli_fetch_assoc($resultWifeWife)) {
                            $counts[$countRow['source']] = $countRow['count'];
                        }

                        ?>
                    <tr>
                        <td>
                            <?php echo $ethnicGroup; ?>
                        </td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo isset($counts['ethnicGroup']) ? $counts['ethnicGroup'] : 0; ?>
                        </b>
                        </td>
                        
                    </tr>
                    <?php
                    }
                ?>
                </tbody>

            </table>

            <h3 class="mt-4 fs-5 fw-bold">&gt; Family Planning/Method used by the Couple</h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">Artificial Family Planning Method</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND artificialFamilyPlanningMethod NOT IN (NULL, '')");

                                
                                $stmt->bind_param("s", $_SESSION['unique_id']);

                                
                                $stmt->execute();

                                
                                $result = $stmt->get_result();

                                
                                $count = $result->num_rows;

                                
                                $stmt->close();
                               

                                
                                echo $count;
                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Permanent Family Planning Method</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND permanentFamilyPlanningMethod NOT IN (NULL, '')");
                                $stmt->bind_param("s", $_SESSION['unique_id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $count = $result->num_rows;
                                $stmt->close();
                                echo $count;
                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Natural Family Planning Method</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND naturalFamilyPlanningMethod NOT IN (NULL, '')");

                                
                                $stmt->bind_param("s", $_SESSION['unique_id']);

                                
                                $stmt->execute();

                                
                                $result = $stmt->get_result();

                                
                                $count = $result->num_rows;

                                
                                $stmt->close();
                               

                                
                                echo $count;
                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold"><i>No. of Couple Attending RPM</i></td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND attendedResponsibleParentingMovementClass = 'Yes'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>

                            </b>
                        </td>
                    </tr>
                </tbody>

            </table>


            <h3 class="mt-4 fs-5 fw-bold">&gt; Household Unit Occupied<br>
                    <span class="text-decoration-underline ml-5 pl-4">OWNERSHIP</span>
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">Owner</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfHousingUnitOccupied = 'Owned'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Rented</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfHousingUnitOccupied = 'Rented'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Caretaker</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfHousingUnitOccupied = 'Caretaker'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                </tbody>

            </table>



            <h3 class="mt-4 fs-5 fw-bold text-decoration-underline ml-5 pl-4">HOUSE STRUCTURE<br>
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="fw-bold">Permanent/Concrete</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Permanent - concrete'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Temporary/Wooden</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Temporary - wooden'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Makeshift/Cogon/Bamboo, <br>Barong-barong</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Makeshift - cogon/bamboo'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                </tbody>

            </table>

            <h3 class="mt-4 fs-5 fw-bold text-decoration-underline ml-5 pl-4">HOUSE TYPE<br>
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="fw-bold">Single</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Single'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Duplex</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Duplex'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Commercial/Industrial/Agricultural</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Commercial/industrial/agricultural'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>

                    <tr>
                        <td class="fw-bold">Apartment</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND subTypeOfHousingUnitOccupied = 'Apartment/accessoria/condominium'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                </tbody>

            </table>

            <h3 class="mt-4 fs-5 fw-bold ">Type of House Light
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="fw-bold">Electricity</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfHouseLightUsed = 'Electricity'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">OTHERS</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfHouseLightUsed <> ''");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                </tbody>

            </table>

            <h3 class="mt-4 fs-5 fw-bold ">Type of Water Supply
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="fw-bold">TAP</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Tap - (Inside house)'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">SPRING</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Spring'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">DUG WELL</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Dug Well'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">DEEP WELL</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Deep Well'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">PUBLIC WELL</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Public Well'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">PUBLIC FAUCET</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Public Faucet'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">NONE</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'None'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                </tbody>

            </table>


            <h3 class="mt-4 fs-5 fw-bold ">Type of Toilet
            </h3>
            <table border="0">
                <thead>
                    <tr>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                        <th scope="col fw-bold" width="300">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td class="fw-bold">WATER-SEALED</td>
                        <td>
                            <b>
                            - &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php

                            $stmt = $conn->prepare("SELECT COUNT(*) FROM survey_form_records WHERE unique_id = ? AND typeOfWaterSupply = 'Tap - (Inside house)'");
                            $stmt->bind_param("s", $_SESSION['unique_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $count = $result->num_rows;

                            $stmt->close();
                            

                            echo $count;

                            ?>
                            </b>
                        </td>
                    </tr>
                    
                    
                </tbody>

            </table>

        </div>
    </main>
    <script>
    window.onload = function() {
        // printPage()
    }

    let main = document.querySelector('main');
    // main.classList.add('hidden');

    function printPage() {
        main.classList.remove('hidden');
        window.print();

        window.addEventListener('afterprint', function() {
            main.classList.add('hidden');
        });
    }
    </script>
</body>

</html>