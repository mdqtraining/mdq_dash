<div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">
    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div style="display: flex; flex-wrap: wrap; width: 100%;">
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
                                            <a href="{{ route('appraisal.view',$appraisal->id)}}" class="dropdown-item">
                                                <i class="fa fa-eye mr-2"></i> View
                                            </a>
                                            @if ($role_id == 1)
                                            <a class="dropdown-item" href="{{ route('appraisal.edit', $appraisal->id) }}">
                                                <i class="fa fa-edit mr-2"></i> Edit
                                            </a>
                                            <a class="dropdown-item delete-table-row" href="{{ route('appraisal.destroy', $appraisal->id) }}">
                                                <i class="fa fa-trash mr-2"></i> Delete
                                            </a>
                                            @endif
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
        <div class="d-flex justify-content-between align-items-center">
            <!-- Entries Per Page Dropdown -->
            <div class="dataTables_length">
                <label style="display:flex; align-items: center; gap: 10px; margin: 0;">
                    <span>Show</span>
                    <select class="custom-select custom-select-sm form-control form-control-sm"
                        onchange="window.location.href = '?per_page=' + this.value;">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>entries</span>
                </label>
            </div>

            <!-- Info Section -->
            <div class="dataTables_info">
                Showing {{ $appraisals->firstItem() }} to {{ $appraisals->lastItem() }} of {{ $appraisals->total() }} entries
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    {{-- Previous Button --}}
                    <li class="page-item {{ $appraisals->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link text-white {{ $appraisals->onFirstPage() ? 'bg-secondary' : 'bg-primary' }}"
                            href="{{ $appraisals->onFirstPage() ? '#' : $appraisals->previousPageUrl() }}">
                            Previous
                        </a>
                    </li>

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $appraisals->lastPage(); $i++)
                        <li class="page-item {{ ($appraisals->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link {{ ($appraisals->currentPage() == $i) ? 'bg-dark text-white border-dark' : '' }}"
                                href="{{ $appraisals->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        {{-- Next Button --}}
                        <li class="page-item {{ $appraisals->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link text-white {{ $appraisals->hasMorePages() ? 'bg-primary' : 'bg-secondary' }}"
                                href="{{ $appraisals->hasMorePages() ? $appraisals->nextPageUrl() : '#' }}">
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