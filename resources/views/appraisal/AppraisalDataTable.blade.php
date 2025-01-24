<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover border-0 w-100 dataTable no-footer">
                    <thead>
                        <tr>
                            <th scope="col">Branch</th>
                            <th scope="col">Department</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Target Rating</th>
                            <th scope="col">Overall Rating</th>
                            <th scope="col">Appraisal Date</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <?php

                    $data = [
                        ['USA', 'IT', 'Senior Developer', 'John Doe', 4.2, 4.0, '2023/10'],
                        ['UK', 'Marketing', 'Marketing Lead', 'Jane Smith', 3.9, 3.7, '2024/02'],
                        ['India', 'Finance', 'Accountant', 'Amit Patel', 4.1, 4.0, '2025/06'],
                        ['Germany', 'Logistics', 'Warehouse Manager', 'Hans Muller', 3.8, 3.6, '2023/12'],
                        ['Japan', 'Research', 'Lab Scientist', 'Akira Yamamoto', 4.5, 4.3, '2026/05'],
                        ['Brazil', 'Sales', 'Sales Manager', 'Carlos Silva', 4.0, 3.8, '2024/11'],
                        ['Australia', 'HR', 'HR Specialist', 'Emily Brown', 4.3, 4.1, '2025/01'],
                        ['Canada', 'IT', 'Project Manager', 'Sarah Connor', 4.6, 4.4, '2026/09'],
                        ['South Africa', 'Operations', 'Operations Lead', 'Lebo Dlamini', 4.2, 4.1, '2024/07'],
                        ['France', 'Design', 'Creative Director', 'Marie Curie', 4.7, 4.5, '2025/04'],
                    ];
                    // Start the table
                    echo "<tbody>";

                    // Loop through the data array
                    foreach ($data as $row) {
                        $rating1 = $row[4];
                        $rating2 = $row[5];
                        $date = $row[6];

                        echo "<tr>";
                        echo "<td>{$row[0]}</td>";
                        echo "<td>{$row[1]}</td>";
                        echo "<td>{$row[2]}</td>";
                        echo "<td>{$row[3]}</td>";
                        // Rating 1
                        echo "<td>";
                        echo "<div class='star-rating' data-rating='{$rating1}'>";
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($rating1)) {
                                // Full star
                                $star = "&#9733;";  // Full star symbol
                            } elseif ($i == ceil($rating1) && $rating1 != floor($rating1)) {
                                // Half star (for fractional ratings)
                                $star = "&#9733;";  // Half star symbol
                                echo "<span class='star half' data-value='{$i}'>{$star}</span>";
                                continue;
                            } else {
                                // Empty star
                                $star = "&#9734;";  // Empty star symbol
                            }
                            // Echo the star
                            echo "<span class='star' data-value='{$i}'>{$star}</span>";
                        }

                        echo "</div>";
                        echo " ({$rating1} / 5)";
                        echo "</td>";

                        // Rating 2
                        echo "<td>";
                        echo "<div class='star-rating' data-rating='{$rating2}'>";
                        // Assuming $rating2 is a decimal value (e.g., 3.5)
                        for ($i = 1; $i <= 5; $i++) {
                            // Check if the current star should be filled
                            if ($i <= floor($rating2)) {
                                $star = "&#9733;";  // Full star
                            } elseif ($i == ceil($rating2) && $rating2 != floor($rating2)) {
                                $star = "&#9733;";  // Half star (not filled completely)
                                echo "<span class='star half' data-value='{$i}'>{$star}</span>";
                                continue;
                            } else {
                                $star = "&#9734;";  // Empty star
                            }

                            // Echo the star
                            echo "<span class='star' data-value='{$i}'>{$star}</span>";
                        }

                        echo "</div>";
                        echo " ({$rating2} / 5)";
                        echo "</td>";

                        // Date
                        echo "<td>{$date}</td>";

                        echo "<td class='text-right pr-20'>";
                        echo "<div class='task_view'>";
                        echo "    <div class='dropdown'>";
                        echo "        <a class='task_view_more d-flex align-items-center justify-content-center dropdown-toggle' type='link' id='dropdownMenuLink-55' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                        echo "            <i class='icon-options-vertical icons'></i>";
                        echo "        </a>";
                        echo "        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenuLink-55' tabindex='0'>";
                        echo "            <a href='' class='dropdown-item'>";
                        echo "                <i class='fa fa-eye mr-2'></i> View";
                        echo "            </a>";
                        echo "            <a class='dropdown-item openRightModal' href=''>";
                        echo "                <i class='fa fa-edit mr-2'></i> Edit";
                        echo "            </a>";
                        echo "            <a class='dropdown-item delete-table-row' href='javascript:;'>";
                        echo "                <i class='fa fa-trash mr-2'></i> Delete";
                        echo "            </a>";
                        echo "        </div>";
                        echo "    </div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // End the table
                    echo "</tbody>";
                    ?>

                </table>
            </div>
        </div>
        <div class="d-flex" style="display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: nowrap;">
            <!-- Show Entries Section -->
            <div class="flex-grow-1" style="flex-grow: 1; display: flex; align-items: center;">
                <div class="dataTables_length" style="display: flex; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 10px; margin: 0;">
                        <span>Show</span>
                        <select class="custom-select custom-select-sm form-control form-control-sm" style="height: 35px; width: 70px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entries</span>
                    </label>
                </div>
            </div>

            <!-- Info Section -->
            <div style="white-space: nowrap; text-align: center;">
                <div class="dataTables_info" id="leads-table_info" role="status" aria-live="polite" style="white-space: nowrap; padding: 0px !important;">
                    <
                        Showing 1 to <?php echo count($data); ?> of <?php echo count($data); ?> entries
                        </div>
                </div>

                <!-- Pagination Section -->
                <div style="display: flex; align-items: center; justify-content: flex-end;">
                    <div class="dataTables_paginate paging_simple_numbers" id="leads-table_paginate" style="display: flex; align-items: center;">
                        <ul class="pagination" style="margin: 0; display: flex; list-style: none; padding: 0; gap: 5px;">
                            <li class="paginate_button page-item previous disabled" id="leads-table_previous">
                                <a href="#" aria-controls="leads-table" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                            </li>
                            <li class="paginate_button page-item active">
                                <a href="#" aria-controls="leads-table" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                            </li>
                            <li class="paginate_button page-item next disabled" id="leads-table_next">
                                <a href="#" aria-controls="leads-table" data-dt-idx="2" tabindex="0" class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const starContainers = document.querySelectorAll(".star-rating");

            starContainers.forEach(container => {
                const stars = container.querySelectorAll(".star");
                const rating = parseFloat(container.getAttribute("data-rating"));

                // Apply the 'active' class for whole number ratings
                stars.forEach(star => {
                    const value = parseFloat(star.getAttribute("data-value"));
                    if (value <= Math.floor(rating)) {
                        star.classList.add("active");
                    }
                });

                // Handle fractional ratings (e.g., 3.5)
                if (!Number.isInteger(rating)) {
                    const fractionalStar = stars[Math.floor(rating)];
                    if (fractionalStar) {
                        fractionalStar.style.backgroundImage = "linear-gradient(90deg, gold 50%, #ccc 50%)";
                        fractionalStar.style.color = "transparent";
                        fractionalStar.style.webkitBackgroundClip = "text";
                    }
                }
            });
        });
        // JavaScript to handle the glowing stars
        document.addEventListener("DOMContentLoaded", function() {
            const starContainers = document.querySelectorAll(".star-rating");

            starContainers.forEach(container => {
                const stars = container.querySelectorAll(".star");
                const rating = parseFloat(container.getAttribute("data-rating"));

                // Apply the 'active' class for whole number ratings
                stars.forEach(star => {
                    const value = parseFloat(star.getAttribute("data-value"));
                    if (value <= Math.floor(rating)) {
                        star.classList.add("active");
                    }
                });

                // Handle fractional ratings (e.g., 3.5)
                if (!Number.isInteger(rating)) {
                    const fractionalStar = stars[Math.floor(rating)];
                    if (fractionalStar) {
                        fractionalStar.style.backgroundImage = "linear-gradient(90deg, gold 50%, #ccc 50%)";
                        fractionalStar.style.color = "transparent";
                        fractionalStar.style.webkitBackgroundClip = "text";
                    }
                }
            });
        });
    </script>