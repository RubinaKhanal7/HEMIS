@extends('backend.layouts.master')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Student Statistics Reports</h2>

        <!-- Report Selection -->
        <div class="mb-4">
            <select id="reportType" class="form-select">
                <option value="">Select Report Type</option>
                <option value="enrollment">Student Enrollment Details</option>
                <option value="faculty-gender">Students by Faculty and Gender</option>
                <option value="faculty-ethnicity">Students by Faculty and Ethnicity</option>
                <option value="level-gender">Students by Level and Gender</option>
                <option value="program-gender">Students by Program and Gender</option>
                <option value="program-ethnicity-gender">Students by Program, Ethnicity and Gender</option>
                <option value="district-ethnicity-gender">Students by District, Ethnicity and Gender</option>
                <option value="province-ethnicity-gender">Students by Province, Ethnicity and Gender</option>
                <option value="faculty-level-program-local">Students by Faculty, Level, Program and Municipality</option>
                <option value="graduated-statistics">Graduated Students Statistics</option>
                <option value="pass-rates">Student Pass Rates by Level, Faculty and Gender</option>
                <option value="teacher-staff-details">Teachers and Staff Details</option>
                <option value="teacher-staff-ethnicity">Teachers and Staff by Ethnicity and Gender</option>
                <option value="teacher-staff-position">Teachers and Staff by Position, Job Type and Gender</option>
                <option value="campus-enrollment-summary">Campus Enrollment Summary</option>
                <option value="dropout-statistics">Dropout Statistics by Gender and Program</option>
            </select>
            </select>
        </div>

        <!-- Batch Selection for Enrollment Report -->
        <div id="batchSelector" class="mb-4" style="display: none;">
            <select id="batch" class="form-select">
                <option value="">Select Batch Year</option>
                <option value="2080">2080</option>
                <option value="2079">2079</option>
                <option value="2078">2078</option>
            </select>
        </div>

        <!-- Report Display Area -->
        <div id="reportContent">
            <!-- Reports will be loaded here via AJAX -->
        </div>
    </div>

    <!-- Report Templates -->
    <template id="enrollment-template">
        <div class="table-responsive">
            <h3>Student Enrollment Details - Batch <span class="batch-year"></span></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roll No</th>
                        <th>District</th>
                        <th>Local Level</th>
                        <th>Ethnicity</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Faculty</th>
                        <th>Level</th>
                        <th>Program</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample static data -->
                    <tr>
                        <td>Aarav Sharma</td>
                        <td>2080-001</td>
                        <td>Kathmandu</td>
                        <td>Kathmandu Metro</td>
                        <td>Brahmin</td>
                        <td>Male</td>
                        <td>20</td>
                        <td>Science</td>
                        <td>Bachelor</td>
                        <td>BSc CSIT</td>
                    </tr>
                    <tr>
                        <td>Aasha Tamang</td>
                        <td>2080-002</td>
                        <td>Lalitpur</td>
                        <td>Lalitpur Metro</td>
                        <td>Janajati</td>
                        <td>Female</td>
                        <td>19</td>
                        <td>Management</td>
                        <td>Bachelor</td>
                        <td>BBA</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="faculty-gender-template">
        <div>
            <h3>Students by Faculty and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Faculty</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Science</td>
                        <td>150</td>
                        <td>100</td>
                        <td>250</td>
                    </tr>
                    <tr>
                        <td>Management</td>
                        <td>120</td>
                        <td>130</td>
                        <td>250</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="faculty-ethnicity-template">
        <div>
            <h3>Students by Faculty and Ethnicity</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Faculty</th>
                        <th>Brahmin</th>
                        <th>Chhetri</th>
                        <th>Janajati</th>
                        <th>Dalit</th>
                        <th>Others</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Science</td>
                        <td>80</td>
                        <td>70</td>
                        <td>60</td>
                        <td>20</td>
                        <td>20</td>
                        <td>250</td>
                    </tr>
                    <tr>
                        <td>Management</td>
                        <td>75</td>
                        <td>65</td>
                        <td>70</td>
                        <td>25</td>
                        <td>15</td>
                        <td>250</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="level-gender-template">
        <div>
            <h3>Students by Level and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bachelor</td>
                        <td>200</td>
                        <td>180</td>
                        <td>380</td>
                    </tr>
                    <tr>
                        <td>Master</td>
                        <td>70</td>
                        <td>50</td>
                        <td>120</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="program-gender-template">
        <div>
            <h3>Students by Program and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BSc CSIT</td>
                        <td>90</td>
                        <td>60</td>
                        <td>150</td>
                    </tr>
                    <tr>
                        <td>BBA</td>
                        <td>70</td>
                        <td>80</td>
                        <td>150</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="program-ethnicity-gender-template">
        <div>
            <h3>Students by Program, Ethnicity and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Program</th>
                        <th colspan="3">Brahmin</th>
                        <th colspan="3">Chhetri</th>
                        <th colspan="3">Janajati</th>
                        <th colspan="3">Dalit</th>
                        <th colspan="3">Others</th>
                    </tr>
                    <tr>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BSc CSIT</td>
                        <td>30</td>
                        <td>20</td>
                        <td>50</td>
                        <td>25</td>
                        <td>15</td>
                        <td>40</td>
                        <td>20</td>
                        <td>15</td>
                        <td>35</td>
                        <td>10</td>
                        <td>5</td>
                        <td>15</td>
                        <td>5</td>
                        <td>5</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>BBA</td>
                        <td>25</td>
                        <td>30</td>
                        <td>55</td>
                        <td>20</td>
                        <td>25</td>
                        <td>45</td>
                        <td>15</td>
                        <td>20</td>
                        <td>35</td>
                        <td>5</td>
                        <td>5</td>
                        <td>10</td>
                        <td>2</td>
                        <td>3</td>
                        <td>5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="district-ethnicity-gender-template">
        <div>
            <h3>Students by District, Ethnicity and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">District</th>
                        <th colspan="3">Brahmin</th>
                        <th colspan="3">Chhetri</th>
                        <th colspan="3">Janajati</th>
                        <th colspan="3">Dalit</th>
                        <th colspan="3">Others</th>
                    </tr>
                    <tr>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kathmandu</td>
                        <td>40</td>
                        <td>35</td>
                        <td>75</td>
                        <td>30</td>
                        <td>25</td>
                        <td>55</td>
                        <td>25</td>
                        <td>20</td>
                        <td>45</td>
                        <td>10</td>
                        <td>8</td>
                        <td>18</td>
                        <td>5</td>
                        <td>2</td>
                        <td>7</td>
                    </tr>
                    <tr>
                        <td>Lalitpur</td>
                        <td>30</td>
                        <td>25</td>
                        <td>55</td>
                        <td>25</td>
                        <td>20</td>
                        <td>45</td>
                        <td>20</td>
                        <td>15</td>
                        <td>35</td>
                        <td>8</td>
                        <td>7</td>
                        <td>15</td>
                        <td>3</td>
                        <td>2</td>
                        <td>5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="province-ethnicity-gender-template">
        <div>
            <h3>Students by Province, Ethnicity and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Province</th>
                        <th colspan="3">Brahmin</th>
                        <th colspan="3">Chhetri</th>
                        <th colspan="3">Janajati</th>
                        <th colspan="3">Dalit</th>
                        <th colspan="3">Others</th>
                    </tr>
                    <tr>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                        <th>M</th>
                        <th>F</th>
                        <th>T</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bagmati</td>
                        <td>80</td>
                        <td>70</td>
                        <td>150</td>
                        <td>60</td>
                        <td>50</td>
                        <td>110</td>
                        <td>50</td>
                        <td>40</td>
                        <td>90</td>
                        <td>20</td>
                        <td>15</td>
                        <td>35</td>
                        <td>10</td>
                        <td>5</td>
                        <td>15</td>
                    </tr>
                    <tr>
                        <td>Gandaki</td>
                        <td>50</td>
                        <td>45</td>
                        <td>95</td>
                        <td>40</td>
                        <td>35</td>
                        <td>75</td>
                        <td>35</td>
                        <td>30</td>
                        <td>65</td>
                        <td>15</td>
                        <td>10</td>
                        <td>25</td>
                        <td>8</td>
                        <td>7</td>
                        <td>15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="faculty-level-program-local-template">
        <div>
            <h3>Students by Faculty, Level, Program and Municipality</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Faculty</th>
                        <th>Level</th>
                        <th>Program</th>
                        <th>Municipality</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Science</td>
                        <td>Bachelor</td>
                        <td>BSc CSIT</td>
                        <td>Kathmandu Metropolitan</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>Science</td>
                        <td>Bachelor</td>
                        <td>BSc CSIT</td>
                        <td>Lalitpur Metropolitan</td>
                        <td>80</td>
                    </tr>
                    <tr>
                        <td>Management</td>
                        <td>Bachelor</td>
                        <td>BBA</td>
                        <td>Kathmandu Metropolitan</td>
                        <td>100</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="graduated-statistics-template">
        <div>
            <h3>Graduated Students by Faculty, Program, Gender and Caste Ethnicity</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Faculty</th>
                        <th>Program</th>
                        <th>Gender</th>
                        <th>Ethnicity</th>
                        <th>Total Graduates</th>
                        <th>Graduation Year</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Science</td>
                        <td>BSc CSIT</td>
                        <td>Male</td>
                        <td>Brahmin</td>
                        <td>25</td>
                        <td>2080</td>
                    </tr>
                    <tr>
                        <td>Science</td>
                        <td>BSc CSIT</td>
                        <td>Female</td>
                        <td>Brahmin</td>
                        <td>20</td>
                        <td>2080</td>
                    </tr>
                    <tr>
                        <td>Management</td>
                        <td>BBA</td>
                        <td>Male</td>
                        <td>Janajati</td>
                        <td>15</td>
                        <td>2080</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <template id="pass-rates-template">
        <div>
            <h3>Student Pass Rates by Level, Faculty and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Faculty</th>
                        <th>Male Pass Rate (%)</th>
                        <th>Female Pass Rate (%)</th>
                        <th>Overall Pass Rate (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bachelor</td>
                        <td>Science</td>
                        <td>85.5</td>
                        <td>88.2</td>
                        <td>86.8</td>
                    </tr>
                    <tr>
                        <td>Bachelor</td>
                        <td>Management</td>
                        <td>82.3</td>
                        <td>84.7</td>
                        <td>83.5</td>
                    </tr>
                    <tr>
                        <td>Master</td>
                        <td>Science</td>
                        <td>90.2</td>
                        <td>91.5</td>
                        <td>90.8</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
    
    <template id="teacher-staff-details-template">
        <div>
            <h3>Teachers and Staff Details</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Qualification</th>
                        <th>Job Type</th>
                        <th>Appointment Date</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dr. Ramesh Adhikari</td>
                        <td>Professor</td>
                        <td>PhD Computer Science</td>
                        <td>Full-time</td>
                        <td>2075-04-15</td>
                        <td>Computer Science</td>
                    </tr>
                    <tr>
                        <td>Sita Sharma</td>
                        <td>Associate Professor</td>
                        <td>MPhil Mathematics</td>
                        <td>Full-time</td>
                        <td>2076-08-20</td>
                        <td>Mathematics</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
    
    <template id="teacher-staff-ethnicity-template">
        <div>
            <h3>Teachers and Staff by Ethnicity and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ethnicity</th>
                        <th>Male Teaching</th>
                        <th>Female Teaching</th>
                        <th>Male Non-Teaching</th>
                        <th>Female Non-Teaching</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Brahmin</td>
                        <td>25</td>
                        <td>15</td>
                        <td>10</td>
                        <td>8</td>
                        <td>58</td>
                    </tr>
                    <tr>
                        <td>Chhetri</td>
                        <td>20</td>
                        <td>12</td>
                        <td>8</td>
                        <td>6</td>
                        <td>46</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
    
    <template id="teacher-staff-position-template">
        <div>
            <h3>Teachers and Staff by Position, Job Type and Gender</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Job Type</th>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Professor</td>
                        <td>Full-time</td>
                        <td>15</td>
                        <td>8</td>
                        <td>23</td>
                    </tr>
                    <tr>
                        <td>Associate Professor</td>
                        <td>Full-time</td>
                        <td>20</td>
                        <td>12</td>
                        <td>32</td>
                    </tr>
                    <tr>
                        <td>Administrative Staff</td>
                        <td>Full-time</td>
                        <td>10</td>
                        <td>15</td>
                        <td>25</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
    
    <template id="campus-enrollment-summary-template">
        <div>
            <h3>Campus Enrollment Summary</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Faculty</th>
                        <th>Program</th>
                        <th>Gender</th>
                        <th>Ethnicity</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bachelor</td>
                        <td>Science</td>
                        <td>BSc CSIT</td>
                        <td>Male</td>
                        <td>Brahmin</td>
                        <td>45</td>
                    </tr>
                    <tr>
                        <td>Bachelor</td>
                        <td>Science</td>
                        <td>BSc CSIT</td>
                        <td>Female</td>
                        <td>Brahmin</td>
                        <td>35</td>
                    </tr>
                    <tr>
                        <td>Master</td>
                        <td>Management</td>
                        <td>MBA</td>
                        <td>Male</td>
                        <td>Janajati</td>
                        <td>25</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
    
    <template id="dropout-statistics-template">
        <div>
            <h3>Dropout Statistics by Gender and Program</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Male Dropouts</th>
                        <th>Female Dropouts</th>
                        <th>Total Dropouts</th>
                        <th>Dropout Rate (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BSc CSIT</td>
                        <td>8</td>
                        <td>5</td>
                        <td>13</td>
                        <td>4.2</td>
                    </tr>
                    <tr>
                        <td>BBA</td>
                        <td>6</td>
                        <td>4</td>
                        <td>10</td>
                        <td>3.8</td>
                    </tr>
                    <tr>
                        <td>MBA</td>
                        <td>3</td>
                        <td>2</td>
                        <td>5</td>
                        <td>2.5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#reportType').change(function() {
                const reportType = $(this).val();
                if (reportType === 'enrollment') {
                    $('#batchSelector').show();
                } else {
                    $('#batchSelector').hide();
                    loadReport(reportType);
                }
            });

            $('#batch').change(function() {
                const reportType = $('#reportType').val();
                const batch = $(this).val();
                if (reportType && batch) {
                    loadReport(reportType, batch);
                }
            });

            function loadReport(reportType, batch = null) {
                // In a real implementation, this would make an AJAX call to the server
                // For now, we'll just load the template
                const template = document.getElementById(`${reportType}-template`);
                if (template) {
                    const content = template.content.cloneNode(true);
                    if (batch) {
                        $(content).find('.batch-year').text(batch);
                    }
                    $('#reportContent').html(content);
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#reportType').change(function() {
                const reportType = $(this).val();
                if (reportType === 'enrollment') {
                    $('#batchSelector').show();
                } else {
                    $('#batchSelector').hide();
                    loadReport(reportType);
                }
            });

            $('#batch').change(function() {
                const reportType = $('#reportType').val();
                const batch = $(this).val();
                if (reportType && batch) {
                    loadReport(reportType, batch);
                }
            });

            function loadReport(reportType, batch = null) {
                // In a real implementation, this would make an AJAX call to the server
                // For now, we'll just load the template
                const template = document.getElementById(`${reportType}-template`);
                if (template) {
                    const content = template.content.cloneNode(true);
                    if (batch) {
                        $(content).find('.batch-year').text(batch);
                    }
                    $('#reportContent').html(content);
                }
            }            
        });

        $(document).ready(function() {
    // Function to load pass rates report
    function loadPassRatesReport() {
        const template = document.getElementById('pass-rates-template');
        if (template) {
            const content = template.content.cloneNode(true);
            $('#reportContent').html(content);
            initializePassRatesFilters();
        }
    }

    // Function to load teacher and staff details
    function loadTeacherStaffDetails() {
        const template = document.getElementById('teacher-staff-details-template');
        if (template) {
            const content = template.content.cloneNode(true);
            $(content).find('table').addClass('teacher-staff-table');
            $('#reportContent').html(content);
            initializeTeacherStaffFilters();
        }
    }

    // Function to load teacher and staff ethnicity report
    function loadTeacherStaffEthnicity() {
        const template = document.getElementById('teacher-staff-ethnicity-template');
        if (template) {
            const content = template.content.cloneNode(true);
            calculateEthnicityTotals(content);
            $('#reportContent').html(content);
        }
    }

    // Function to load teacher and staff position report
    function loadTeacherStaffPosition() {
        const template = document.getElementById('teacher-staff-position-template');
        if (template) {
            const content = template.content.cloneNode(true);
            analyzePositionData(content);
            $('#reportContent').html(content);
        }
    }

    // Function to load campus enrollment summary
    function loadCampusEnrollment() {
        const template = document.getElementById('campus-enrollment-summary-template');
        if (template) {
            const content = template.content.cloneNode(true);
            calculateEnrollmentStats(content);
            $('#reportContent').html(content);
        }
    }

    // Function to load dropout statistics
    function loadDropoutStatistics() {
        const template = document.getElementById('dropout-statistics-template');
        if (template) {
            const content = template.content.cloneNode(true);
            analyzeDropoutTrends(content);
            $('#reportContent').html(content);
        }
    }

    // Helper functions for data analysis and manipulation
    function initializePassRatesFilters() {
        const searchBox = $('<input type="text" class="form-control mb-3" placeholder="Search...">');
        $('.table').before(searchBox);
        
        searchBox.on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            $('.table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    }

    function initializeTeacherStaffFilters() {
        const searchBox = $('<input type="text" class="form-control mb-3" placeholder="Search staff...">');
        $('.teacher-staff-table').before(searchBox);
        
        searchBox.on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            $('.teacher-staff-table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    }

    function calculateEthnicityTotals(content) {
        let totalTeaching = 0;
        let totalNonTeaching = 0;
        
        $(content).find('tbody tr').each(function() {
            const maleTeaching = parseInt($(this).find('td:nth-child(2)').text());
            const femaleTeaching = parseInt($(this).find('td:nth-child(3)').text());
            const maleNonTeaching = parseInt($(this).find('td:nth-child(4)').text());
            const femaleNonTeaching = parseInt($(this).find('td:nth-child(5)').text());
            
            totalTeaching += maleTeaching + femaleTeaching;
            totalNonTeaching += maleNonTeaching + femaleNonTeaching;
        });
        
        // Add totals row
        $(content).find('tbody').append(`
            <tr class="table-info">
                <td><strong>Total</strong></td>
                <td colspan="2">${totalTeaching}</td>
                <td colspan="2">${totalNonTeaching}</td>
                <td>${totalTeaching + totalNonTeaching}</td>
            </tr>
        `);
    }

    function analyzePositionData(content) {
        // Add percentage calculations
        $(content).find('tbody tr').each(function() {
            const male = parseInt($(this).find('td:nth-child(3)').text());
            const female = parseInt($(this).find('td:nth-child(4)').text());
            const total = parseInt($(this).find('td:nth-child(5)').text());
            
            const malePercent = ((male / total) * 100).toFixed(1);
            const femalePercent = ((female / total) * 100).toFixed(1);
            
            $(this).find('td:nth-child(3)').append(`<br><small>(${malePercent}%)</small>`);
            $(this).find('td:nth-child(4)').append(`<br><small>(${femalePercent}%)</small>`);
        });
    }

    function calculateEnrollmentStats(content) {
        let totalStudents = 0;
        let genderDistribution = { male: 0, female: 0 };
        
        $(content).find('tbody tr').each(function() {
            const count = parseInt($(this).find('td:last-child').text());
            totalStudents += count;
            
            const gender = $(this).find('td:nth-child(4)').text();
            if (gender === 'Male') {
                genderDistribution.male += count;
            } else {
                genderDistribution.female += count;
            }
        });
        
        // Add summary statistics
        $(content).before(`
            <div class="alert alert-info">
                <strong>Total Enrollment:</strong> ${totalStudents}<br>
                <strong>Gender Distribution:</strong> 
                Male: ${((genderDistribution.male / totalStudents) * 100).toFixed(1)}% | 
                Female: ${((genderDistribution.female / totalStudents) * 100).toFixed(1)}%
            </div>
        `);
    }

    function analyzeDropoutTrends(content) {
        let totalDropouts = 0;
        let highestRate = 0;
        let programWithHighestRate = '';
        
        $(content).find('tbody tr').each(function() {
            const dropouts = parseInt($(this).find('td:nth-child(4)').text());
            const rate = parseFloat($(this).find('td:nth-child(5)').text());
            totalDropouts += dropouts;
            
            if (rate > highestRate) {
                highestRate = rate;
                programWithHighestRate = $(this).find('td:first-child').text();
            }
        });
        
        // Add trend analysis
        $(content).before(`
            <div class="alert alert-warning">
                <strong>Total Dropouts:</strong> ${totalDropouts}<br>
                <strong>Program with Highest Dropout Rate:</strong> ${programWithHighestRate} (${highestRate}%)
            </div>
        `);
    }

    // Add event listener for report type selection
    $('#reportType').change(function() {
        const reportType = $(this).val();
        switch(reportType) {
            case 'pass-rates':
                loadPassRatesReport();
                break;
            case 'teacher-staff-details':
                loadTeacherStaffDetails();
                break;
            case 'teacher-staff-ethnicity':
                loadTeacherStaffEthnicity();
                break;
            case 'teacher-staff-position':
                loadTeacherStaffPosition();
                break;
            case 'campus-enrollment-summary':
                loadCampusEnrollment();
                break;
            case 'dropout-statistics':
                loadDropoutStatistics();
                break;
        }
    });
});

    </script>
@endsection