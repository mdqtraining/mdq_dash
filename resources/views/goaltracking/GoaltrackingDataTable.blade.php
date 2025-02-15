<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div style="display: flex; flex-wrap: wrap; width: 100%;">
            <div class="col-sm-12">
                <table class="table table-hover border-0 w-100 dataTable no-footer">
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
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody style="width: 100%">
                        @if($goaltracking->count() > 0)
                        @foreach ($goaltracking as $goaltrackings)
                        <tr>
                            <td>{{ $goaltrackings->goal_type }}</td>
                            <td>{{ $goaltrackings->subject }}</td>
                            <td>{{ $goaltrackings->branch }}</td>
                            <td>{{ $goaltrackings->target }}</td>
                            <td>{{ \Carbon\Carbon::parse($goaltrackings->start_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($goaltrackings->end_date)->format('d-m-Y') }}</td>
                            <td >
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
                                    @php $statusColor='danger' ; @endphp
                                    @elseif ($completionPercent>= 50 && $completionPercent < 75)
                                        @php $statusColor='warning' ; @endphp
                                        @else
                                        @php $statusColor='success' ; @endphp
                                        @endif

                                        <div>
                                        {{ $completionPercent }}%
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $statusColor }}" role="progressbar" style="width: {{ $completionPercent }}%;"
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
                            <a href="{{ route('goaltracking.show', $goaltrackings->id) }}" class="dropdown-item">
                                <i class="fa fa-eye mr-2"></i> View
                            </a>
                            <a class="dropdown-item" href="{{ route('goaltracking.edit', $goaltrackings->id) }}">
                                <i class="fa fa-edit mr-2"></i> Edit
                            </a>

                            <a class="dropdown-item delete-table-row" href="{{ route('goaltracking.destroy', $goaltrackings->id) }}"
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
        <!-- Entries Per Page Dropdown -->
        <div class="d-flex ">
            <div class="flex-grow-1">
                <div class="dataTables_length ">
                    <label class="d-flex align-items-center"><span>Show &nbsp;</span><select class="custom-select custom-select-sm form-control form-control-sm" style="width:auto !important;" onchange="window.location.href = '?per_page=' + this.value;">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select><span>&nbsp; entries</span></label>
                </div>
            </div>

            <div>
                <div class="dataTables_info ">
                    Showing {{ $goaltracking->firstItem() }} to {{ $goaltracking->lastItem() }} of {{ $goaltracking->total() }} entries
                </div>
            </div>

            <!-- Pagination Links -->
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    <!-- Previous Button -->
                    <li class="paginate_button page-item {{ $goaltracking->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link text-white {{ $goaltracking->onFirstPage() ? 'bg-secondary' : 'bg-primary' }}"
                            href="{{ $goaltracking->onFirstPage() ? '#' : $goaltracking->previousPageUrl() }}">
                            Previous
                        </a>
                    </li>

                    <!-- Current Page -->
                    <li class="paginate_button page-item active">
                        <span class="page-link bg-dark border-dark">{{ $goaltracking->currentPage() }}</span>
                    </li>

                    <!-- Next Button -->
                    <li class="paginate_button page-item {{ $goaltracking->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link {{ $goaltracking->hasMorePages() ? 'bg-primary' : 'bg-secondary' }} text-white"
                            href="{{ $goaltracking->hasMorePages() ? $goaltracking->nextPageUrl() : '#' }}">
                            Next
                        </a>
                    </li>
                </ul>
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