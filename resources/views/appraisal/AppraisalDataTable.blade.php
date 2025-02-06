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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($appraisals->count() > 0)
                            @foreach ($appraisals as $appraisal)
                                <tr>
                                    <td>{{ $appraisal->branch }}</td>
                                    <td>{{ $appraisal->department }}</td>
                                    <td>{{ $appraisal->designation }}</td>
                                    <td>{{ $appraisal->employee_name }}</td>

                                    <!-- Rating 1 -->
                                    <td>
                                        <div class="star-rating" data-rating="{{ $appraisal->target_rating }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star" data-value="{{ $i }}">&#9733;</span>
                                            @endfor
                                        </div>
                                        <div class="text-dark f-13">({{ $appraisal->target_rating }} / 5)</div>
                                    </td>

                                    <!-- Rating 2 -->
                                    <td>
                                        <div class="star-rating" data-rating="{{ $appraisal->overall_rating }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star" data-value="{{ $i }}">&#9733;</span>
                                            @endfor
                                        </div>
                                        <div class="text-dark f-13">({{ $appraisal->overall_rating }} / 5)</div>
                                    </td>

                                    <!-- Appraisal Date -->
                                    <td>{{ $appraisal->appraisal_date }}</td>

                                    <!-- Action -->
                                    <td class="text-right pr-20">
                                        <div class="task_view">
                                            <div class="dropdown">
                                                <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link" id="dropdownMenuLink-55" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-options-vertical icons"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-55" tabindex="0">
                                                    <a href="" class="dropdown-item">
                                                        <i class="fa fa-eye mr-2"></i> View
                                                    </a>
                                                    <a class="dropdown-item openRightModal" href="">
                                                        <i class="fa fa-edit mr-2"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item delete-table-row" href="javascript:;">
                                                        <i class="fa fa-trash mr-2"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">No records found</td>
                            </tr>
                        @endif
                    </tbody>
                    
                </table>
                
            </div>
            
        </div>
        <div class="d-flex" style="display: flex; align-items: center; justify-content: space-between; gap: 20px;">
            <div class="flex-grow-1" style="flex-grow: 1;">
                <div class="dataTables_length" style="display: flex; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 10px; margin: 0;">
                        <span>Show</span>
                        <select class="custom-select custom-select-sm form-control form-control-sm" style="height: 35px; width: 70px;" onchange="window.location.href = '?per_page=' + this.value;">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>entries</span>
                    </label>
                </div>
            </div>

            <!-- Info Section -->
            <div>
                <div class="dataTables_info" id="leads-table_info" role="status" aria-live="polite" style="white-space: nowrap; padding: 0px !important;">
                    Showing  1 to {{ $appraisal->count() }} of {{ $appraisal->count() }} entries
                </div>
            </div>

            <!-- Pagination Section -->
            <div>
                <div class="dataTables_paginate paging_simple_numbers" id="leads-table_paginate" style="display: flex; align-items: center;">
                    <ul class="pagination" style="margin: 0; display: flex; list-style: none; padding: 0;">
                        <!-- Previous Button -->
                        <li class="paginate_button page-item " id="leads-table_previous" style="margin-right: 5px;">
                            <a href="#" class="page-link">Previous</a>
                        </li>
                        

                            <li class="paginate_button page-item active " style="margin-right: 5px;">
                                <a href="#"class="page-link"> 1</a>
                            </li>

                        
                        <!-- Next Button -->
                        <li class="paginate_button page-item" id="leads-table_next">
                            <a href="#" class="page-link">Next</a>
                        </li>
                    </ul>
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