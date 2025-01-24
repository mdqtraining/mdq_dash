<?php
// Dummy data array
$data = [
    ['Short term goal', 'Complete website redesign', 'India', '500', 'Jan 15, 2025', 'Jan 30, 2025', 4.8, 85],
    ['Long term goal', 'Launch new marketing campaign', 'USA', '2000', 'Feb 1, 2025', 'Feb 28, 2025', 3.9, 62],
    ['Medium term goal', 'Develop mobile app', 'Canada', '1500', 'Mar 10, 2025', 'Apr 20, 2025', 4.3, 78],
    ['Short term goal', 'Increase social media presence', 'UK', '300', 'Jan 5, 2025', 'Jan 20, 2025', 3.6, 50],
    ['Long term goal', 'Expand to new regions', 'Germany', '2500', 'Apr 1, 2025', 'Dec 31, 2025', 4.1, 67],
    ['Short term goal', 'Organize training sessions', 'Australia', '700', 'Jan 10, 2025', 'Feb 5, 2025', 3.4, 48],
    ['Medium term goal', 'Improve customer support system', 'Japan', '1200', 'Feb 15, 2025', 'Mar 30, 2025', 4.7, 80],
    ['Long term goal', 'Increase employee retention', 'India', '1800', 'Mar 1, 2025', 'Dec 31, 2025', 3.5, 60],
    ['Short term goal', 'Host annual conference', 'USA', '400', 'Feb 10, 2025', 'Feb 15, 2025', 4.9, 92],
    ['Medium term goal', 'Launch sustainability initiatives', 'France', '1000', 'May 1, 2025', 'Jul 30, 2025', 4.0, 70],

];

?>
<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover border-0 w-100">
                    <thead>
                        <tr>
                            <th>Goal Type</th>
                            <th>Subject</th>
                            <th>Branch</th>
                            <th>Target Achievement</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Rating</th>
                            <th>Progress</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= $row[0] ?></td>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td><?= $row[3] ?></td>
                                <td><?= $row[4] ?></td>
                                <td><?= $row[5] ?></td>
                                <td>
                                    <div class="star-rating" data-rating="<?= $row[6] ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star" data-value="<?= $i ?>">&#9733;</span>
                                        <?php endfor; ?>
                                        <div class="text-dark f-13">(<?= $row[6] ?> / 5)</div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $completionPercent = $row[7];

                                    if ($completionPercent < 50) {
                                        $statusColor = 'danger'; // Red
                                    } elseif ($completionPercent >= 50 && $completionPercent < 75) {
                                        $statusColor = 'warning'; // Orange
                                    } else {
                                        $statusColor = 'success'; // Green
                                    }

                                    echo '' . $completionPercent . '%
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-' . $statusColor . '" role="progressbar" 
                            style="width: ' . $completionPercent . '%;" 
                            aria-valuenow="' . $completionPercent . '" aria-valuemin="0" aria-valuemax="100">
                            
                            </div>
                        </div>';
                                    ?>
                                </td>
                                <td class=" text-right pr-20">
                                    <div class="task_view">

                                        <div class="dropdown">
                                            <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link" id="dropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-options-vertical icons"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-55" tabindex="0"><a href="" class="dropdown-item"><svg class="svg-inline--fa fa-eye fa-w-18 mr-2" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="eye" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                                    </svg><!-- <i class="fa fa-eye mr-2"></i> Font Awesome fontawesome.com -->View</a><a class="dropdown-item openRightModal" href="http://localhost:8000/account/projects/55/edit">
                                                    <svg class="svg-inline--fa fa-edit fa-w-18 mr-2" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path>
                                                    </svg><!-- <i class="fa fa-edit mr-2"></i> Font Awesome fontawesome.com -->
                                                    Edit
                                                </a><a class="dropdown-item delete-table-row" href="" data-user-id="55">
                                                    <svg class="svg-inline--fa fa-trash fa-w-14 mr-2" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                                        <path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path>
                                                    </svg><!-- <i class="fa fa-trash mr-2"></i> Font Awesome fontawesome.com -->
                                                    Delete
                                                </a></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex" style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
            <div class="flex-grow-1" style="flex-grow: 1;">
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
    <div style="display: flex; align-items: center; justify-content: center; gap: 20px; flex-wrap: wrap;">
    <!-- Info Section -->
    <div>
        <div class="dataTables_info" id="leads-table_info" role="status" aria-live="polite" style="white-space: nowrap; padding: 0px !important;">
            Showing 1 to <?php echo count($data); ?> of <?php echo count($data); ?> entries
        </div>
    </div>

    <!-- Pagination Section -->
    <div>
        <div class="dataTables_paginate paging_simple_numbers" id="leads-table_paginate" style="display: flex; align-items: center;">
            <ul class="pagination" style="margin: 0; display: flex; list-style: none; padding: 0;">
                <li class="paginate_button page-item previous disabled" id="leads-table_previous" style="margin-right: 5px;">
                    <a href="#" aria-controls="leads-table" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                </li>
                <li class="paginate_button page-item active" style="margin-right: 5px;">
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
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const starContainers = document.querySelectorAll(".star-rating");

        starContainers.forEach(container => {
            const stars = container.querySelectorAll(".star");
            const rating = parseFloat(container.getAttribute("data-rating"));

            stars.forEach((star, index) => {
                const value = index + 1; // Star value
                if (value <= Math.floor(rating)) {
                    star.style.color = "gold"; // Full stars
                } else if (value === Math.ceil(rating) && rating % 1 !== 0) {
                    star.style.backgroundImage = `linear-gradient(90deg, gold ${(rating % 1) * 100}%, #ccc ${(rating % 1) * 100}%)`;
                    star.style.webkitBackgroundClip = "text";
                    star.style.color = "transparent"; // Partial star
                } else {
                    star.style.color = "#ccc"; // Empty stars
                }
            });
        });
    });
</script>