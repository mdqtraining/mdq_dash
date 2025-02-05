
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
                    @if($goaltracking->count() > 0)
                        @foreach ($goaltracking as $goaltrackings)
                            <tr>
                                <td>{{ $goaltrackings->goal_type }}</td>
                                <td>{{ $goaltrackings->subject }}</td>
                                <td>{{ $goaltrackings->branch }}</td>
                                <td>{{ $goaltrackings->target_achievement }}</td>
                                <td>{{ $goaltrackings->start_date }}</td>
                                <td>{{ $goaltrackings->end_date }}</td>
                                <td>
                                    <div class="star-rating" data-rating="{{ $goaltrackings->rating }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                                        @endfor
                                    </div>
                                    <div class="text-dark f-13">({{ $goaltrackings->rating }} / 5)</div>
                                </td>
                                <td>
                                    @php
                                    $completionPercent = $goaltrackings->progress;
                                    $statusColor = '';
                                    @endphp

                                    @if ($completionPercent < 50)
                                        @php $statusColor = 'danger'; @endphp
                                    @elseif ($completionPercent >= 50 && $completionPercent < 75)
                                        @php $statusColor = 'warning'; @endphp
                                    @else
                                        @php $statusColor = 'success'; @endphp
                                    @endif

                                    <div>
                                        {{ $completionPercent }}%
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $statusColor }}" role="progressbar" 
                                                 style="width: {{ $completionPercent }}%;" 
                                                 aria-valuenow="{{ $completionPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right pr-20">
                                    <div class="task_view">
                                        <div class="dropdown">
                                            <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" 
                                               type="link" id="dropdownMenuLink-55" data-toggle="dropdown" 
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-options-vertical icons"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-55" tabindex="0">
                                                <a href="" class="dropdown-item">
                                                    <i class="fa fa-eye mr-2"></i> View
                                                </a>
                                                <a class="dropdown-item openRightModal" href="{{ route('goaltracking.edit', $goaltrackings->id) }}">
                                                <i class="fa fa-edit mr-2"></i> Edit
                                                </a>
                                                <a class="dropdown-item delete-table-row" href="{{ route('projects.destroy', $goaltrackings->id) }}" 
                                                   data-user-id="{{ $goaltrackings->id }}">
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
                            <td colspan="9" class="text-center">No data available</td>
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
                    Showing  1 to {{ $goaltracking->count() }} of {{ $goaltracking->count() }} entries
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