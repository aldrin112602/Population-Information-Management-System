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
        header('location: ../');
    }

    if(!isset($_GET['household_id'])) {
     header('location: records.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Survey Form - PIMS | Population Information Monitoring System</title>
    <link rel="stylesheet" href="../src/bootstrap.min.css" />
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />

    <!-- For mobile devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="../img/pims logo.png" />
    <meta name="msapplication-TileImage" content="../img/pims logo.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />

    <!-- Poppins font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <!-- google icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!-- jquery plugin -->
    <script src="../src/jquery.min.js"></script>
    <link rel="stylesheet" href="../src/jquery-ui-1.13.2/jquery-ui.min.css">
    <script src="../src/jquery-ui-1.13.2/jquery-ui.min.js"></script>

    <script src="../src/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
    function setAge(input, target) {
        $(document).ready(function() {
            const inputDate = new Date($(input).val());
            const currentDate = new Date();
            let age = currentDate.getFullYear() - inputDate.getFullYear();
            const birthMonth = inputDate.getMonth();
            const birthDay = inputDate.getDate();
            const currentMonth = currentDate.getMonth();
            const currentDay = currentDate.getDate();
            if (
                currentMonth < birthMonth ||
                (currentMonth === birthMonth && currentDay < birthDay)
            ) {
                age--;
            }

            $(target).val(age);
        });
    }
    </script>

    <!-- custom styles -->
    <style>
    * {
        font-family: "Poppins", sans-serif;
        padding: 0;
        margin: 0;
        transition: all 0.5s;
    }

    input[type="radio"],
    input[type="checkbox"] {
        cursor: pointer;
    }

    .pointer-events-none {
        pointer-events: none;
    }
    </style>
</head>

<body>
    <?php

$husband = getRows("household_id='{$_GET['household_id']}'", "survey_form_records_husband");
$wife = getRows("household_id='{$_GET['household_id']}'", "survey_form_records_wife");
$record = getRows("household_id='{$_GET['household_id']}'", "survey_form_records");
if(count($husband) == 0) header('Location: ./records.php');
?>
    <div class="container-fluid bg-white">
        <br><br>
        <form action="" method="post" class="px-4 pr-0">
            <br>
            <h1 class="text-center fs-3 text-success fw-bolder">FAMILY PROFILE SURVEY FORM</h1>
            <input type="hidden" value="<?php echo $_GET['household_id'] ?>" name="household_id">

            <p class="text-center">Date Accomplished: <strong><?php echo date('m/d/Y') ?></strong></p>
            <div class="mt-5 position-relative">
                <div id="fixed_input" class="row justify-content-center p-0" style="width: 100%;">
                    <div class="row p-3 rounded bg-white col-12 col-md-6 my-2">
                        <div class="container my-2">
                            <label for="purok" class="">PUROK</label>
                            <input value="<?php echo $husband[0]['purok'] ?>" required type="text"
                                class="form-control form-control-lg" id="purok" name="purok">
                        </div>
                        <div class="container my-2">
                            <label for="barangay" class="">BARANGAY</label>
                            <input title="This can't be change, read-only" readonly
                                value="<?php echo $husband[0]['barangay'] ?>" required type="text"
                                class="form-control form-control-lg" id="barangay" name="barangay">

                        </div>
                    </div>

                    <div class="row p-3 rounded bg-white col-12 col-md-6 my-2">
                        <div class="container my-2">
                            <label for="municipality" class="">MUNICIPALITY</label>
                            <input title="This can't be change, read-only" readonly
                                value="<?php echo $husband[0]['municipality'] ?>" required type="text"
                                class="form-control form-control-lg" id="municipality" name="municipality">
                        </div>
                        <div class="container my-2">
                            <label for="province" class="">PROVINCE</label>
                            <input title="This can't be change, read-only" readonly
                                value="<?php echo $husband[0]['province'] ?>" required type="text"
                                class="form-control form-control-lg" id="province" name="province">
                        </div>
                    </div>
                </div>


                <div class="row justify-content-between" id="form">
                    <div class="container my-2">
                        <label for="purok" class="">Household</label>
                        <input value="<?php echo $husband[0]['household'] ?>" required type="text"
                            class="form-control form-control-lg" id="household" name="household">

                    </div>
                    <div class="row border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2">
                        <h5 class="col-12 fw-bold">Husband Information</h5>
                        <div class="col-12 col-md-6 my-2">
                            <label>Name</label>
                            <input value="<?php echo $husband[0]['name'] ?>" required type="text"
                                class="form-control form-control-lg" name="name[]">
                            <input value="husband" type="hidden" class="form-control form-control-lg" name="type[]">

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Civil Status</label>
                            <select required class="form-select form-select-lg" name="status[]">
                                <option selected disabled value=""></option>
                                <option value="Single"
                                    <?php echo $husband[0]['status'] == 'Single' ? 'selected' : null ?>>Single</option>
                                <option value="Married"
                                    <?php echo $husband[0]['status'] == 'Married' ? 'selected' : null ?>>Married
                                </option>
                                <option value="Divorced"
                                    <?php echo $husband[0]['status'] == 'Divorced' ? 'selected' : null ?>>Divorced
                                </option>
                                <option value="Widowed"
                                    <?php echo $husband[0]['status'] == 'Widowed' ? 'selected' : null ?>>Widowed
                                </option>
                                <option value="Live-in"
                                    <?php echo $husband[0]['status'] == 'Live-in' ? 'selected' : null ?>>Live-in
                                </option>
                            </select>

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Date of Birth</label>
                            <input value="<?php echo $husband[0]['dateOfBirth'] ?>" oninput="setAge(this, '#age')"
                                required type="date" class="form-control form-control-lg" name="dateOfBirth[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Age</label>
                            <input value="<?php echo $husband[0]['age'] ?>" id="age" readonly type="number"
                                class="form-control form-control-lg" name="age[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Sex</label>
                            <select required class="form-select form-select-lg pointer-events-none" name="sex[]">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Birth Place</label>
                            <input value="<?php echo $husband[0]['birthPlace'] ?>" required type="text"
                                class="form-control form-control-lg" name="birthPlace[]">
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label class="">Educational attainment</label>
                            <select required class="form-select form-select-lg" name="educationalAttainment[]">
                                <option value="" disabled selected></option>
                                <option value="no-schooling"
                                    <?php echo $husband[0]['educationalAttainment'] == 'no-schooling' ? 'selected' : null ?>>
                                    No Schooling</option>
                                <option value="elementary-school"
                                    <?php echo $husband[0]['educationalAttainment'] == 'elementary-school' ? 'selected' : null ?>>
                                    Elementary School</option>
                                <option value="middle-school"
                                    <?php echo $husband[0]['educationalAttainment'] == 'middle-school' ? 'selected' : null ?>>
                                    Middle School</option>
                                <option value="high-school"
                                    <?php echo $husband[0]['educationalAttainment'] == 'high-school' ? 'selected' : null ?>>
                                    High School</option>
                                <option value="vocational-school"
                                    <?php echo $husband[0]['educationalAttainment'] == 'vocational-school' ? 'selected' : null ?>>
                                    Vocational School</option>
                                <option value="some-college"
                                    <?php echo $husband[0]['educationalAttainment'] == 'some-college' ? 'selected' : null ?>>
                                    Some College</option>
                                <option value="associate-degree"
                                    <?php echo $husband[0]['educationalAttainment'] == 'associate-degree' ? 'selected' : null ?>>
                                    Associate Degree</option>
                                <option value="bachelor-degree"
                                    <?php echo $husband[0]['educationalAttainment'] == 'bachelor-degree' ? 'selected' : null ?>>
                                    Bachelor's Degree</option>
                                <option value="master-degree"
                                    <?php echo $husband[0]['educationalAttainment'] == 'master-degree' ? 'selected' : null ?>>
                                    Master's Degree</option>
                                <option value="doctoral-degree"
                                    <?php echo $husband[0]['educationalAttainment'] == 'doctoral-degree' ? 'selected' : null ?>>
                                    Doctoral Degree</option>
                            </select>

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Occupation</label>
                            <input value="<?php echo $husband[0]['occupation'] ?>" required type="text"
                                class="form-control form-control-lg" name="occupation[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Place of work</label>
                            <input value="<?php echo $husband[0]['placeOfWork'] ?>" required type="text"
                                class="form-control form-control-lg" name="placeOfWork[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Religion</label>
                            <input value="<?php echo $husband[0]['religion'] ?>" required list="religion_list"
                                name="religion[]" class="form-control form-control-lg">
                            <datalist id="religion_list">
                                <?php
                                            $religions = array(
                                                "Roman Catholicism",
                                                "Protestantism",
                                                "Islam",
                                                "Buddhism",
                                                "Iglesia ni Cristo",
                                                "Aglipayan Church",
                                                "Seventh-day Adventist Church",
                                                "Jehovah's Witnesses",
                                                "The Church of Jesus Christ of Latter-day Saints",
                                                "Hinduism",
                                                "Judaism",
                                                "Taoism",
                                                'Members of the Church of God International',
                                                "Anitism",
                                                "Bahá'í Faith",
                                                "Confucianism",
                                                "Shinto",
                                                "Soka Gakkai",
                                                "Eckankar",
                                                "Rastafarianism",
                                                "Brahma Kumaris",
                                                "Theosophy",
                                                "Scientology",
                                                'Jewish'

                                            );

                                        foreach ($religions as $religion) {
                                            echo '<option value="' . $religion . '">';
                                        }
                                        
                                        ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Ethnic Group</label>
                            <input value="<?php echo $husband[0]['ethnicGroup'] ?>" required type="text"
                                class="form-control form-control-lg" name="ethnicGroup[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Choose an option:</label>
                            <select required class="form-select form-select-lg" name="option[]">
                                <option value="" disabled selected></option>
                                <option value="Living"
                                    <?php echo $husband[0]['life_status'] == 'Living' ? 'selected' : null ?>>Living
                                </option>
                                <option value="Disease"
                                    <?php echo $husband[0]['life_status'] == 'Disease' ? 'selected' : null ?>>Disease
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2">
                        <h5 class="col-12 fw-bold">Wife Information</h5>
                        <div class="col-12 col-md-6 my-2">
                            <label>Name</label>
                            <input value="<?php echo $wife[0]['name'] ?>" required type="text"
                                class="form-control form-control-lg" name="name[]">
                            <input value="wife" type="hidden" class="form-control form-control-lg" name="type[]">

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Civil Status</label>
                            <select required class="form-select form-select-lg" name="status[]">
                                <option selected disabled value=""></option>
                                <option value="Single" <?php echo $wife[0]['status'] == 'Single' ? 'selected' : null ?>>
                                    Single</option>
                                <option value="Married"
                                    <?php echo $wife[0]['status'] == 'Married' ? 'selected' : null ?>>Married
                                </option>
                                <option value="Divorced"
                                    <?php echo $wife[0]['status'] == 'Divorced' ? 'selected' : null ?>>Divorced
                                </option>
                                <option value="Widowed"
                                    <?php echo $wife[0]['status'] == 'Widowed' ? 'selected' : null ?>>Widowed
                                </option>
                                <option value="Live-in"
                                    <?php echo $wife[0]['status'] == 'Live-in' ? 'selected' : null ?>>Live-in
                                </option>
                            </select>

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Date of Birth</label>
                            <input value="<?php echo $wife[0]['dateOfBirth'] ?>" oninput="setAge(this, '#age')" required
                                type="date" class="form-control form-control-lg" name="dateOfBirth[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Age</label>
                            <input value="<?php echo $wife[0]['age'] ?>" id="age" readonly type="number"
                                class="form-control form-control-lg" name="age[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Sex</label>
                            <select required class="form-select form-select-lg pointer-events-none" name="sex[]">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Birth Place</label>
                            <input value="<?php echo $wife[0]['birthPlace'] ?>" required type="text"
                                class="form-control form-control-lg" name="birthPlace[]">
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label class="">Educational attainment</label>
                            <select required class="form-select form-select-lg" name="educationalAttainment[]">
                                <option value="" disabled selected></option>
                                <option value="no-schooling"
                                    <?php echo $wife[0]['educationalAttainment'] == 'no-schooling' ? 'selected' : null ?>>
                                    No Schooling</option>
                                <option value="elementary-school"
                                    <?php echo $wife[0]['educationalAttainment'] == 'elementary-school' ? 'selected' : null ?>>
                                    Elementary School</option>
                                <option value="middle-school"
                                    <?php echo $wife[0]['educationalAttainment'] == 'middle-school' ? 'selected' : null ?>>
                                    Middle School</option>
                                <option value="high-school"
                                    <?php echo $wife[0]['educationalAttainment'] == 'high-school' ? 'selected' : null ?>>
                                    High School</option>
                                <option value="vocational-school"
                                    <?php echo $wife[0]['educationalAttainment'] == 'vocational-school' ? 'selected' : null ?>>
                                    Vocational School</option>
                                <option value="some-college"
                                    <?php echo $wife[0]['educationalAttainment'] == 'some-college' ? 'selected' : null ?>>
                                    Some College</option>
                                <option value="associate-degree"
                                    <?php echo $wife[0]['educationalAttainment'] == 'associate-degree' ? 'selected' : null ?>>
                                    Associate Degree</option>
                                <option value="bachelor-degree"
                                    <?php echo $wife[0]['educationalAttainment'] == 'bachelor-degree' ? 'selected' : null ?>>
                                    Bachelor's Degree</option>
                                <option value="master-degree"
                                    <?php echo $wife[0]['educationalAttainment'] == 'master-degree' ? 'selected' : null ?>>
                                    Master's Degree</option>
                                <option value="doctoral-degree"
                                    <?php echo $wife[0]['educationalAttainment'] == 'doctoral-degree' ? 'selected' : null ?>>
                                    Doctoral Degree</option>
                            </select>

                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Occupation</label>
                            <input value="<?php echo $wife[0]['occupation'] ?>" required type="text"
                                class="form-control form-control-lg" name="occupation[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Place of work</label>
                            <input value="<?php echo $wife[0]['placeOfWork'] ?>" required type="text"
                                class="form-control form-control-lg" name="placeOfWork[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Religion</label>
                            <input value="<?php echo $wife[0]['religion'] ?>" required list="religion_list"
                                name="religion[]" class="form-control form-control-lg">
                            <datalist id="religion_list">
                                <?php
                                            $religions = array(
                                                "Roman Catholicism",
                                                "Protestantism",
                                                "Islam",
                                                "Buddhism",
                                                "Iglesia ni Cristo",
                                                "Aglipayan Church",
                                                "Seventh-day Adventist Church",
                                                "Jehovah's Witnesses",
                                                "The Church of Jesus Christ of Latter-day Saints",
                                                "Hinduism",
                                                "Judaism",
                                                "Taoism",
                                                'Members of the Church of God International',
                                                "Anitism",
                                                "Bahá'í Faith",
                                                "Confucianism",
                                                "Shinto",
                                                "Soka Gakkai",
                                                "Eckankar",
                                                "Rastafarianism",
                                                "Brahma Kumaris",
                                                "Theosophy",
                                                "Scientology",
                                                'Jewish'

                                            );

                                        foreach ($religions as $religion) {
                                            echo '<option value="' . $religion . '">';
                                        }
                                        
                                        ?>
                            </datalist>
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Ethnic Group</label>
                            <input value="<?php echo $wife[0]['ethnicGroup'] ?>" required type="text"
                                class="form-control form-control-lg" name="ethnicGroup[]">
                        </div>
                        <div class="col-12 col-md-6 my-2">
                            <label class="">Choose an option:</label>
                            <select required class="form-select form-select-lg" name="option[]">
                                <option value="" disabled selected></option>
                                <option value="Living"
                                    <?php echo $wife[0]['life_status'] == 'Living' ? 'selected' : null ?>>Living
                                </option>
                                <option value="Disease"
                                    <?php echo $wife[0]['life_status'] == 'Disease' ? 'selected' : null ?>>Disease
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 col-md-6">
                            <strong>Artificial Family Planning method</strong>
                            <?php
                            $familyPlanningMethods = explode(', ', $record[0]['artificialFamilyPlanningMethod'] ?? '');
                            $availableMethods = ['Pills', 'Condom', 'IUD', 'DMPA'];

                            foreach ($availableMethods as $method) {
                                $isChecked = in_array($method, $familyPlanningMethods) ? 'checked' : '';
                                ?>
                            <div class="form-check">
                                <input <?php echo $isChecked; ?> class="form-check-input" type="checkbox"
                                    name="artificialFamilyPlanningMethod[]" value="<?php echo $method; ?>">
                                <label class="form-check-label">
                                    <?php echo $method; ?>
                                </label>
                            </div>
                            <?php } ?>

                        </div>
                        <div class="col-12 col-md-6">
                            <strong>Permanent Family Planning method</strong>
                            <?php
                            $permanentMethods = explode(', ', $record[0]['permanentFamilyPlanningMethod'] ?? '');
                            $availablePermanentMethods = ['Tubal Ligation', 'Vasectomy'];

                            foreach ($availablePermanentMethods as $method) {
                                $isChecked = in_array($method, $permanentMethods) ? 'checked' : '';
                                ?>
                            <div class="form-check">
                                <input <?php echo $isChecked; ?> class="form-check-input" type="checkbox"
                                    name="permanentFamilyPlanningMethod[]" value="<?php echo $method; ?>">
                                <label class="form-check-label">
                                    <?php echo $method; ?>
                                </label>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-12 col-md-6 my-3">
                            <strong>Natural Family Planning method</strong>
                            <?php
                            $naturalFamilyPlanningMethods = explode(', ', $record[0]['naturalFamilyPlanningMethod'] ?? '') ?? [];
                            ?>

                            <div class="form-check">
                                <input
                                    <?php echo in_array('Basal Body Temperature (BBT)', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Basal Body Temperature (BBT)">
                                <label class="form-check-label">
                                    Basal Body Temperature (BBT)
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Cervical Mucus or Billing Method', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Cervical Mucus or Billing Method">
                                <label class="form-check-label">
                                    Cervical Mucus or Billing Method
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Sympto-Thermal Method', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Sympto-Thermal Method">
                                <label class="form-check-label">
                                    Sympto-Thermal Method
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Lactational Amenorrhea Method (LAM)', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Lactational Amenorrhea Method (LAM)">
                                <label class="form-check-label">
                                    Lactational Amenorrhea Method (LAM)
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Standard Days Method (SDM)', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Standard Days Method (SDM)">
                                <label class="form-check-label">
                                    Standard Days Method (SDM)
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Two-day Method', $naturalFamilyPlanningMethods) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="naturalFamilyPlanningMethod[]"
                                    value="Two-day Method">
                                <label class="form-check-label">
                                    Two-day Method
                                </label>
                            </div>


                        </div>
                        <div class="col-12 col-md-6 my-3">
                            <strong>Have you attended Responsible Parenting Movement Class?</strong>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['attendedResponsibleParentingMovementClass'] ?? null) == 'Yes' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required
                                    name="attendedResponsibleParentingMovementClass" value="Yes">
                                <label class="form-check-label">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['attendedResponsibleParentingMovementClass'] ?? null) == 'No' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required
                                    name="attendedResponsibleParentingMovementClass" value="No">
                                <label class="form-check-label">
                                    No
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Type of Housing Unit Occupied</p>
                            <?php
                                $typeOfHousingUnitOccupied = $record[0]['typeOfHousingUnitOccupied'] ?? null;
                                $subTypeOfHousingUnitOccupied = explode(', ', $record[0]['subTypeOfHousingUnitOccupied'] ?? '');
                            ?>

                            <div class="form-check">
                                <input <?php echo ($typeOfHousingUnitOccupied == 'Owned') ? 'checked' : null; ?>
                                    class="form-check-input" type="radio" required name="typeOfHousingUnitOccupied"
                                    value="Owned">
                                <label class="form-check-label">
                                    Owned
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo ($typeOfHousingUnitOccupied == 'Rented') ? 'checked' : null; ?>
                                    class="form-check-input" type="radio" required name="typeOfHousingUnitOccupied"
                                    value="Rented">
                                <label class="form-check-label">
                                    Rented
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo ($typeOfHousingUnitOccupied == 'Caretaker') ? 'checked' : null; ?>
                                    class="form-check-input" type="radio" required name="typeOfHousingUnitOccupied"
                                    value="Caretaker">
                                <label class="form-check-label">
                                    Caretaker
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    <?php echo in_array('Permanent - concrete', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Permanent - concrete">
                                <label class="form-check-label">
                                    Permanent - concrete
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Temporary - wooden', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Temporary - wooden">
                                <label class="form-check-label">
                                    Temporary - wooden
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Makeshift - cogon/bamboo', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Makeshift - cogon/bamboo">
                                <label class="form-check-label">
                                    Makeshift - cogon/bamboo
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Single', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Single">
                                <label class="form-check-label">
                                    Single
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Duplex', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Duplex">
                                <label class="form-check-label">
                                    Duplex
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Commercial/industrial/agricultural', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Commercial/industrial/agricultural">
                                <label class="form-check-label">
                                    Commercial/industrial/agricultural
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Apartment/accessoria/condominium', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Apartment/accessoria/condominium">
                                <label class="form-check-label">
                                    Apartment/accessoria/condominium
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Improvised barong-barong', $subTypeOfHousingUnitOccupied) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="subTypeOfHousingUnitOccupied[]"
                                    value="Improvised barong-barong">
                                <label class="form-check-label">
                                    Improvised barong-barong
                                </label>
                            </div>

                        </div>

                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Type of House Light used</p>
                            <div class="form-check">
                                <input id="aa"
                                    <?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) == 'Electricity' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfHouseLightUsed"
                                    value="Electricity">
                                <label class="form-check-label">
                                    Electricity
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="aa"
                                    <?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) == 'Gas Lamp' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfHouseLightUsed"
                                    value="Gas Lamp">
                                <label class="form-check-label">
                                    Gas Lamp
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="othersTypeOfHouseLightUsed"
                                    <?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) == 'Others' ? 'checked' : null ?>
                                    name="typeOfHouseLightUsed" class="form-check-input" type="radio" required>
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input
                                    style="display: <?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) == 'Others' ? 'block' : 'none'; ?>"
                                    id="othersTypeOfHouseLightUsedInput" class="form-control form-control-sm"
                                    type="text" required
                                    value="<?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) == 'Others' ? $record[0]['specifyTypeOfHouseLightUsed'] : ''; ?>"
                                    <?php echo ($record[0]['typeOfHouseLightUsed'] ?? null) != 'Others' ? 'disabled' : ''; ?>>
                            </div>

                            <script>
                            $("#othersTypeOfHouseLightUsed").on("change", function() {
                                $("#othersTypeOfHouseLightUsedInput").show().attr('disabled', false);
                            }), $("#othersTypeOfHouseLightUsedInput").on("input", function() {
                                $("#othersTypeOfHouseLightUsed").val(this.value)
                            }), document.querySelectorAll("#aa").forEach(e => {
                                e.onclick = function() {
                                    $("#othersTypeOfHouseLightUsedInput").hide().attr('disabled', true);
                                }
                            });
                            </script>
                        </div>

                        <div class="col-12 col-md-6 mt-4">
                            <p class="fw-bold">Type of Water Supply</p>
                            <?php
                            $typeOfWaterSupply = explode(', ', $record[0]['typeOfWaterSupply'] ?? '');
                            ?>

                            <div class="form-check">
                                <input
                                    <?php echo in_array('Tap - (Inside house)', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]"
                                    value="Tap - (Inside house)">
                                <label class="form-check-label">
                                    Tap - (Inside house)
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Spring', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]" value="Spring">
                                <label class="form-check-label">
                                    Spring
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Dug Well', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]"
                                    value="Dug Well">
                                <label class="form-check-label">
                                    Dug Well
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Deep Well', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]"
                                    value="Deep Well">
                                <label class="form-check-label">
                                    Deep Well
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Public Faucet', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]"
                                    value="Public Faucet">
                                <label class="form-check-label">
                                    Public Faucet
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Public Well', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]"
                                    value="Public Well">
                                <label class="form-check-label">
                                    Public Well
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('None', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfWaterSupply[]" value="None">
                                <label class="form-check-label">
                                    None
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo in_array('Others', $typeOfWaterSupply) ? 'checked' : ''; ?>
                                    id="othersTypeOfWaterSupply" class="form-check-input" type="checkbox"
                                    name="typeOfWaterSupply[]">
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input <?php echo in_array('Others', $typeOfWaterSupply) ? '' : 'disabled'; ?>
                                    style="display: <?php echo in_array('Others', $typeOfWaterSupply) ? 'block' : 'none'; ?>"
                                    id="othersTypeOfWaterSupplyInput" class="form-control form-control-sm" type="text"
                                    required
                                    value="<?php echo in_array('Others', $typeOfWaterSupply) ? implode(', ', array_diff($typeOfWaterSupply, ['Others'])) : ''; ?>">
                            </div>


                            <script>
                            $("#othersTypeOfWaterSupply").on("change", function() {
                                $("#othersTypeOfWaterSupplyInput").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            });
                            </script>
                        </div>

                        <div class="col-12 col-md-6 mt-4">
                            <p class="fw-bold">Type of Toilet</p>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['typeOfToilet'] ?? null) == 'Water-sealed' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfToilet"
                                    value="Water-sealed">
                                <label class="form-check-label">
                                    Water-sealed
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['typeOfToilet'] ?? null) == 'Water-sealed shared with other HH' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfToilet"
                                    value="Water-sealed shared with other HH">
                                <label class="form-check-label">
                                    Water-sealed shared with other HH
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['typeOfToilet'] ?? null) == 'Closed Pit' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfToilet"
                                    value="Closed Pit">
                                <label class="form-check-label">
                                    Closed Pit
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo ($record[0]['typeOfToilet'] ?? null) == 'Open Pit' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfToilet" value="Open Pit">
                                <label class="form-check-label">
                                    Open Pit
                                </label>
                            </div>
                            <div class="form-check">
                                <input <?php echo ($record[0]['typeOfToilet'] ?? null) == 'None' ? 'checked' : null ?>
                                    class="form-check-input" type="radio" required name="typeOfToilet" value="None">
                                <label class="form-check-label">
                                    None
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Type of Garbage Disposal</p>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Picked By Garbage Truck', explode(', ', $record[0]['typeOfGarbageDisposal'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfGarbageDisposal[]"
                                    value="Picked By Garbage Truck">
                                <label class="form-check-label">
                                    Picked By Garbage Truck
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Waste Segregation', explode(', ', $record[0]['typeOfGarbageDisposal'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfGarbageDisposal[]"
                                    value="Waste Segregation">
                                <label class="form-check-label">
                                    Waste Segregation
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Composting', explode(', ', $record[0]['typeOfGarbageDisposal'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfGarbageDisposal[]"
                                    value="Composting">
                                <label class="form-check-label">
                                    Composting
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Burning', explode(', ', $record[0]['typeOfGarbageDisposal'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfGarbageDisposal[]"
                                    value="Burning">
                                <label class="form-check-label">
                                    Burning
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Burying', explode(', ', $record[0]['typeOfGarbageDisposal'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="typeOfGarbageDisposal[]"
                                    value="Burying">
                                <label class="form-check-label">
                                    Burying
                                </label>
                            </div>


                        </div>
                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Communication Facility</p>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Cable', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Cable">
                                <label class="form-check-label">
                                    Cable
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Television', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Television">
                                <label class="form-check-label">
                                    Television
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Radio', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Radio">
                                <label class="form-check-label">
                                    Radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Two-way Radio', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Two-way Radio">
                                <label class="form-check-label">
                                    Two-way Radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Mobile Phone', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Mobile Phone">
                                <label class="form-check-label">
                                    Mobile Phone
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Landline Phone', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="Landline Phone">
                                <label class="form-check-label">
                                    Landline Phone
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('None', explode(', ', $record[0]['communicationFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="communicationFacility[]"
                                    value="None">
                                <label class="form-check-label">
                                    None
                                </label>
                            </div>

                        </div>
                        <div class="col-12 col-md-6 mt-4">
                            <p class="fw-bold">Transport Facility</p>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Bicycle', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="Bicycle">
                                <label class="form-check-label">
                                    Bicycle
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Motorcycle', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]"
                                    value="Motorcycle">
                                <label class="form-check-label">
                                    Motorcycle
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Tricycle', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]"
                                    value="Tricycle">
                                <label class="form-check-label">
                                    Tricycle
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Jeep', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="Jeep">
                                <label class="form-check-label">
                                    Jeep
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Car', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="Car">
                                <label class="form-check-label">
                                    Car
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Truck', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="Truck">
                                <label class="form-check-label">
                                    Truck
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Van', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="Van">
                                <label class="form-check-label">
                                    Van
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Kuliglig', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]"
                                    value="Kuliglig">
                                <label class="form-check-label">
                                    Kuliglig
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('None', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="transportFacility[]" value="None">
                                <label class="form-check-label">
                                    None
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="othersTransportFacility"
                                    <?php echo in_array('Others', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input disabled name="transportFacility[]" style="display: none;"
                                    id="othersTransportFacilityInput" class="form-control form-control-sm" type="text"
                                    required
                                    <?php echo in_array('Others', explode(', ', $record[0]['transportFacility'] ?? '')) ? 'value="' . $record[0]['transportFacilityOthers'] . '"' : ''; ?>>
                            </div>

                            <script>
                            $("#othersTransportFacility").on("change", function() {
                                $("#othersTransportFacilityInput").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            });
                            </script>
                        </div>
                        <div class="col-12 col-md-6 mt-4">
                            <p class="fw-bold">Agricultural Products</p>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Rice', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="agriculturalProduct[]" value="Rice">
                                <label class="form-check-label">
                                    Rice
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Corn', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="agriculturalProduct[]" value="Corn">
                                <label class="form-check-label">
                                    Corn
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Banana', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="agriculturalProduct[]"
                                    value="Banana">
                                <label class="form-check-label">
                                    Banana
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Taro/Gabi', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="agriculturalProduct[]"
                                    value="Taro/Gabi">
                                <label class="form-check-label">
                                    Taro/Gabi
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    <?php echo in_array('Cassava', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    class="form-check-input" type="checkbox" name="agriculturalProduct[]"
                                    value="Cassava">
                                <label class="form-check-label">
                                    Cassava
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="othersAgriculturalProduct"
                                    <?php echo in_array('Others', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'checked' : ''; ?>
                                    name="agriculturalProduct[]" class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input disabled style="display: none;" id="othersAgriculturalProductInput"
                                    class="form-control form-control-sm" type="text" required
                                    <?php echo in_array('Others', explode(', ', $record[0]['agriculturalProduct'] ?? '')) ? 'value="' . $record[0]['agriculturalProductOthers'] . '"' : ''; ?>>
                            </div>

                            <script>
                            $("#othersAgriculturalProduct").on("change", function() {
                                $("#othersAgriculturalProductInput").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            });
                            </script>
                        </div>



                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 col-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Poultry</th>
                                            <th scope="col"># of Heads</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Chicken</th>
                                            <td>
                                                <input type="number" name="poultryNumberOfHeadsChicken"
                                                    class="form-control"
                                                    value="<?php echo $record[0]['poultryNumberOfHeadsChicken'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Duck</th>
                                            <td>
                                                <input type="number" name="poultryNumberOfHeadsDuck"
                                                    class="form-control"
                                                    value="<?php echo $record[0]['poultryNumberOfHeadsDuck'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Geese</th>
                                            <td>
                                                <input type="number" name="poultryNumberOfHeadsGeese"
                                                    class="form-control"
                                                    value="<?php echo $record[0]['poultryNumberOfHeadsGeese'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Turkey</th>
                                            <td>
                                                <input type="number" name="poultryNumberOfHeadsTurkey"
                                                    class="form-control"
                                                    value="<?php echo $record[0]['poultryNumberOfHeadsTurkey'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Others, specify:</th>
                                            <td>
                                                <input type="text" name="poultryOthers" placeholder="Please specify"
                                                    class="form-control my-2"
                                                    value="<?php echo $record[0]['poultryOthers'] ?? null ?>">
                                                <input type="number" name="poultryNumberOfHeadsOthers"
                                                    placeholder="Enter # of Heads" class="form-control"
                                                    value="<?php echo $record[0]['poultryNumberOfHeadsOthers'] ?? null ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col-12 col-md-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Livestock</th>
                                            <th scope="col"># of Heads</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Pig</th>
                                            <td>
                                                <input type="number" name="livestockNumberPig" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberPig'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Goat</th>
                                            <td>
                                                <input type="number" name="livestockNumberGoat" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberGoat'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Sheep</th>
                                            <td>
                                                <input type="number" name="livestockNumberSheep" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberSheep'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Coat</th>
                                            <td>
                                                <input type="number" name="livestockNumberCoat" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberCoat'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Carabao</th>
                                            <td>
                                                <input type="number" name="livestockNumberCarabao" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberCarabao'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Horse</th>
                                            <td>
                                                <input type="number" name="livestockNumberHorse" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberHorse'] ?? null ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Others, specify:</th>
                                            <td>
                                                <input type="text" name="othersLivestock" placeholder="Please specify"
                                                    class="form-control my-2"
                                                    value="<?php echo $record[0]['othersLivestock'] ?? null ?>">
                                                <input type="number" name="livestockNumberOthers"
                                                    placeholder="Enter # of Heads" class="form-control"
                                                    value="<?php echo $record[0]['livestockNumberOthers'] ?? null ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Other source of income</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="otherSourceOfIncome[]"
                                    value="Sari-sari store"
                                    <?php echo in_array('Sari-sari store', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Sari-sari store
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="otherSourceOfIncome[]"
                                    value="Restaurant"
                                    <?php echo in_array('Restaurant', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Restaurant
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="otherSourceOfIncome[]"
                                    value="Bakeshop"
                                    <?php echo in_array('Bakeshop', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Bakeshop
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="othersOtherSourceOfIncome" name="otherSourceOfIncome[]"
                                    class="form-check-input" type="checkbox"
                                    <?php echo in_array('Others', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input disabled
                                    style="display: <?php echo in_array('Others', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? 'block' : 'none'; ?>;"
                                    id="othersOtherSourceOfIncomeInput" class="form-control form-control-sm" type="text"
                                    required
                                    value="<?php echo in_array('Others', explode(', ', $record[0]['otherSourceOfIncome'] ?? [])) ? $record[0]['otherSourceOfIncome'] : ''; ?>">
                            </div>

                            <script>
                            $("#othersOtherSourceOfIncome").on("change", function() {
                                $("#othersOtherSourceOfIncomeInput").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            });
                            </script>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="fw-bold">Fishpond Owned</p>
                            <div class="form-check">
                                <input id="abc" class="form-check-input" type="radio" required name="fishpondOwned"
                                    value="With"
                                    <?php echo ($record[0]['fishpondOwned'] ?? null) === 'With' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    With
                                </label>
                                <input name="fishpondOwnedArea" placeholder="Enter area"
                                    <?php echo ($record[0]['fishpondOwned'] ?? null) === 'With' ? '' : 'disabled'; ?>
                                    style="display: <?php echo ($record[0]['fishpondOwned'] ?? null) === 'With' ? 'block' : 'none'; ?>;"
                                    id="othersFishpondOwnedInput" class="form-control form-control-sm" type="text"
                                    required>
                            </div>
                            <div class="form-check">
                                <input id="wt" class="form-check-input" type="radio" required name="fishpondOwned"
                                    value="Without"
                                    <?php echo ($record[0]['fishpondOwned'] ?? null) === 'Without' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Without
                                </label>
                            </div>

                            <script>
                            $("#abc").on("change", function() {
                                $("#othersFishpondOwnedInput").show().attr('disabled', false);
                            }), $("#othersFishpondOwnedInput").on("input", function() {
                                $("#othersFishpondOwned").val(this.value)
                            }), document.querySelectorAll("#wt").forEach(e => {
                                e.onclick = function() {
                                    $("#othersFishpondOwnedInput").hide().attr('disabled', true);
                                }
                            });
                            </script>
                        </div>
                        <div class="col-12 col-md-6 mt-3">
                            <p class="fw-bold">Land Owned</p>
                            <div class="form-check">
                                <input id="aba" class="form-check-input" type="checkbox" name="landOwned[]"
                                    value="Rice Field"
                                    <?php echo in_array('Rice Field', explode(', ', $record[0]['landOwned'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Rice Field
                                </label>
                                <input name="landOwnedRiceFieldArea" placeholder="Enter area"
                                    <?php echo in_array('Rice Field', explode(', ', $record[0]['landOwned'] ?? [])) ? '' : 'disabled'; ?>
                                    style="display: <?php echo in_array('Rice Field', explode(', ', $record[0]['landOwned'] ?? [])) ? 'block' : 'none'; ?>;"
                                    value="<?php echo ($record[0]['landOwnedRiceFieldArea'] ?? null) ?>" id="rice_area"
                                    class="form-control form-control-sm" type="text" required>
                            </div>
                            <div class="form-check">
                                <input id="abb" class="form-check-input" type="checkbox" name="landOwned[]"
                                    value="Corn Field"
                                    <?php echo in_array('Corn Field', explode(', ', $record[0]['landOwned'] ?? [])) ? 'checked' : ''; ?>>

                                <label class="form-check-label">
                                    Corn Field
                                </label>
                                <input name="landOwnedCornFieldArea" placeholder="Enter area"
                                    <?php echo in_array('Corn Field', explode(', ', $record[0]['landOwned'] ?? [])) ? '' : 'disabled'; ?>
                                    style="display: <?php echo in_array('Corn Field', explode(', ', $record[0]['landOwned'] ?? [])) ? 'd-block' : 'd-none'; ?>;"
                                    value="<?php echo ($record[0]['landOwnedCornFieldArea'] ?? null) ?>" id="corn_area"
                                    class="form-control form-control-sm" type="text" required>
                            </div>
                            <div class="form-check">
                                <input id="abbb" class="form-check-input" type="checkbox"
                                    <?php echo in_array('Others', explode(', ', $record[0]['landOwned'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Others, specify
                                </label>
                                <input name="landOwned[]" placeholder="Specify"
                                    <?php echo in_array('Others', explode(', ', $record[0]['landOwned'] ?? [])) ? '' : 'disabled'; ?>
                                    style="display: <?php echo in_array('Others', explode(', ', $record[0]['landOwned'] ?? [])) ? 'block' : 'none'; ?>;"
                                    id="othersLandOwned" class="form-control form-control-sm" type="text" required>
                            </div>

                            <script>
                            $("#aba").on("change", function() {
                                $("#rice_area").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            })
                            $("#abb").on("change", function() {
                                $("#corn_area").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            })

                            $("#abbb").on("change", function() {
                                $("#othersLandOwned").toggle(0, function() {
                                    $(this).attr('disabled', !$(this).attr('disabled'));
                                })
                            })
                            </script>
                        </div>
                        <div class="col-12 col-md-6 mt-3">
                            <p class="fw-bold">Land</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="land[]" value="Lease"
                                    <?php echo in_array('Lease', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Lease
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="land[]" value="Teanant"
                                    <?php echo in_array('Teanant', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Teanant
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="cc" class="form-check-input" type="checkbox" name="land[]" value="Caretaker"
                                    <?php echo in_array('Caretaker', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Caretaker
                                </label>
                                <div id="sub_"
                                    style="display: <?php echo in_array('Caretaker', explode(', ', $record[0]['land'] ?? [])) ? 'block' : 'none'; ?>;">
                                    <div class="form-check">
                                        <input id="_aba" class="form-check-input" type="checkbox"
                                            <?php echo in_array('Rice Field', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">
                                            Rice Field
                                        </label>
                                        <input name="caretakerRiceArea" placeholder="Enter area" disabled
                                            style="display: <?php echo in_array('Rice Field', explode(', ', $record[0]['land'] ?? [])) ? 'block' : 'none'; ?>;"
                                            id="_rice_area" class="form-control form-control-sm" type="text" required
                                            value="<?php echo in_array('Rice Field', explode(', ', $record[0]['land'] ?? [])) ? $record[0]['caretakerRiceArea'] : ''; ?>">
                                    </div>
                                    <div class="form-check">
                                        <input id="_abb" class="form-check-input" type="checkbox" name="land[]"
                                            value="Corn Field"
                                            <?php echo in_array('Corn Field', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">
                                            Corn Field
                                        </label>
                                        <input name="caretakerCornArea" placeholder="Enter area" disabled
                                            style="display: <?php echo in_array('Corn Field', explode(', ', $record[0]['land'] ?? [])) ? 'block' : 'none'; ?>;"
                                            id="_corn_area" class="form-control form-control-sm" type="text" required
                                            value="<?php echo in_array('Corn Field', explode(', ', $record[0]['land'] ?? [])) ? $record[0]['caretakerCornArea'] : ''; ?>">
                                    </div>
                                    <div class="form-check">
                                        <input id="_abbb" class="form-check-input" type="checkbox"
                                            <?php echo in_array('Others, specify', explode(', ', $record[0]['land'] ?? [])) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">
                                            Others, specify
                                        </label>
                                        <input name="caretakerOthersLandOwned" placeholder="Specify" disabled
                                            style="display: <?php echo in_array('Others, specify', explode(', ', $record[0]['land'] ?? [])) ? 'block' : 'none'; ?>;"
                                            id="_othersLandOwned" class="form-control form-control-sm" type="text"
                                            required
                                            value="<?php echo in_array('Others, specify', explode(', ', $record[0]['land'] ?? [])) ? $record[0]['caretakerOthersLandOwned'] : ''; ?>">
                                    </div>
                                    <script>
                                    $("#_aba").on("change", function() {
                                        $("#_rice_area").toggle(0, function() {
                                            $(this).attr('disabled', !$(this).attr('disabled'));
                                        })
                                    })
                                    $("#_abb").on("change", function() {
                                        $("#_corn_area").toggle(0, function() {
                                            $(this).attr('disabled', !$(this).attr('disabled'));
                                        })
                                    })

                                    $("#_abbb").on("change", function() {
                                        $("#_othersLandOwned").toggle(0, function() {
                                            $(this).attr('disabled', !$(this).attr('disabled'));
                                        })
                                    })
                                    </script>
                                </div>
                            </div>

                            <script>
                            $("#cc").on("change", function() {
                                $("#sub_").toggle();
                            })
                            </script>
                        </div>


                    </div>
                    <div class="border  py-5 p-3 rounded bg-white col-12 col-md-6 my-2 row">
                        <div class="col-12 my-3">
                            <strong>Monthly Average Family Income</strong>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="monthlyAverageFamilyIncome"
                                    value="Below 5,000.00"
                                    <?php echo ($record[0]['monthlyAverageFamilyIncome'] ?? null) === 'Below 5,000.00' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    Below 5,000.00
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="monthlyAverageFamilyIncome"
                                    value="5,000.00 - 9,000.00"
                                    <?php echo ($record[0]['monthlyAverageFamilyIncome'] ?? null) === '5,000.00 - 9,000.00' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    5,000.00 - 9,000.00
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="monthlyAverageFamilyIncome"
                                    value="10,000.00 - 29,000.00"
                                    <?php echo ($record[0]['monthlyAverageFamilyIncome'] ?? null) === '10,000.00 - 29,000.00' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    10,000.00 - 29,000.00
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="monthlyAverageFamilyIncome"
                                    value="30,000.00 - 69,000.00"
                                    <?php echo ($record[0]['monthlyAverageFamilyIncome'] ?? null) === '30,000.00 - 69,000.00' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    30,000.00 - 69,000.00
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" required name="monthlyAverageFamilyIncome"
                                    value="70,000 above"
                                    <?php echo ($record[0]['monthlyAverageFamilyIncome'] ?? null) === '70,000 above' ? 'checked' : ''; ?>>
                                <label class="form-check-label">
                                    70,000 above
                                </label>
                            </div>

                        </div>
                        <div class="col-12 mt-5">
                            <button type="button" class="btn btn-danger" onclick="leavePage()">Cancel</button>
                            <script>
                            function leavePage() {
                                if (confirm('Are you sure to leave this page?')) {
                                    location.assign('./');
                                }
                            }
                            </script>
                            <button type="submit" class="btn btn-success">Save update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php 
        require_once('handle_survey_form_update.php');
    ?>
</body>

</html>