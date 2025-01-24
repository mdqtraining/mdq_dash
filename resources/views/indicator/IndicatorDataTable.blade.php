<?php
// Dummy data array
$data = [
    ['USA', 'IT', 'Senior Developer',  4.0, 'owner', '2023/10/02'],
    ['UK', 'Marketing', 'Marketing Lead', 3.7, 'owner', '2024/02/20'],
    ['India', 'Finance', 'Accountant',  4.0, 'owner', '2025/06/15'],
    ['Germany', 'Logistics', 'Warehouse Manager', 3.6, 'owner', '2023/12/05'],
    ['Japan', 'Research', 'Lab Scientist', 4.3, 'officer', '2026/05/05'],
    ['Brazil', 'Sales', 'Sales Manager', 3.8, 'employe', '2024/11/28'],
    ['Australia', 'HR', 'HR Specialist', 4.1, 'manager', '2025/01/30'],
    ['Canada', 'IT', 'Project Manager', 4.4, 'HR', '2026/09/12'],
    ['South Africa', 'Operations', 'Operations Lead', 4.1, 'admin', '2024/07/15'],
    ['France', 'Design', 'Creative Director', 4.5, 'harish', '2025/04/22'],
];
?>
<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover border-0 w-100">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Overall Rating</th>
                            <th>Added By</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= $row[0] ?></td>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td>
                                    <div class="star-rating" data-rating="<?= $row[3] ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star" data-value="<?= $i ?>">&#9733;</span>
                                        <?php endfor; ?>
                                        <div class="text-dark f-13">(<?= $row[3] ?> / 5)</div>
                                    </div>
                                </td>
                                <td><?= $row[4] ?></td>
                                <td><?= $row[5] ?></td>

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