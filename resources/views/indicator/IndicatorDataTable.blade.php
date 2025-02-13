@php
use Carbon\Carbon;
@endphp

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
                        @if($indicators->count() > 0)
                        @foreach ($indicators as $indicator)
                        <tr>
                            <td>{{ $indicator->branch }}</td>
                            <td>{{ $indicator->department }}</td>
                            <td>{{ $indicator->designation }}</td>
                            <td>
                                <div class="star-rating" data-rating="{{ $indicator->rating }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star" data-value="{{ $i }}">
                                        {!! $i <= floor($indicator->rating) ? '&#9733;' : ($i == ceil($indicator->rating) && fmod($indicator->rating, 1) != 0 ? '&#9733;' : '&#9734;') !!}
                                            </span>
                                            @endfor
                                </div>
                                <div class="text-dark f-13">({{ $indicator->rating }} / 5)</div>
                            </td>
                            <td>{{ $indicator->added_by }}</td>
                            <td>{{ Carbon::parse($indicator->created_at)->format('d-m-Y') }}</td>
                            <td class="text-right pr-20">
                                <div class="task_view">
                                    <div class="dropdown">
                                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle"
                                            type="link" id="dropdownMenuLink-{{ $indicator->id }}"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-options-vertical icons"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" tabindex="0">
                                            <a href="{{ route('indicator.view', $indicator->id) }}" class="dropdown-item">
                                                <i class="fa fa-eye mr-2"></i>View
                                            </a>
                                            <a class="dropdown-item" href="{{ route('indicator.edit', $indicator->id) }}">
                                                <i class="fa fa-edit mr-2"></i>Edit
                                            </a>
                                            <form action="{{ route('indicator.destroy', $indicator->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item delete-button"
                                                    style="border: none; background: none; cursor: pointer;">
                                                    <i class="fa fa-trash mr-2"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">No records found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination and Entries Selection -->
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
            <div class="dataTables_info ">
                Showing {{ $indicators->firstItem() }} to {{ $indicators->lastItem() }} of {{ $indicators->total() }} entries
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center ">
                
                <ul class="pagination">
                    <li class="page-item {{ $indicators->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link text-white {{ $indicators->onFirstPage() ? 'bg-secondary' : 'bg-primary' }}"
                            href="{{ $indicators->onFirstPage() ? '#' : $indicators->previousPageUrl() }}">
                            &laquo; Previous
                        </a>
                    </li>
   
                    {{-- Current Page --}}
                    <li class="page-item active">
                        <span class="page-link bg-dark text-white border-dark">{{ $indicators->currentPage() }}</span>
                    </li>

                    {{-- Next Button --}}
                    <li class="page-item {{ $indicators->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link text-white {{ $indicators->hasMorePages() ? 'bg-primary' : 'bg-secondary' }}"
                            href="{{ $indicators->hasMorePages() ? $indicators->nextPageUrl() : '#' }}">
                            Next &raquo;
                        </a>
                    </li>
                </ul>
               
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-indicator").forEach(button => {
            button.addEventListener("click", function() {
                let indicatorId = this.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this record?")) {
                    fetch(`/account/indicator/delete/${indicatorId}`, {
                            method: "POST", // Send POST request (not DELETE)
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                _method: "DELETE"
                            }) // Laravel method spoofing
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message); // Show success message
                            location.reload(); // Reload the page after successful deletion
                        })
                        .catch(error => console.error("Error:", error));
                }
            });
        });

        // ⭐ Star rating display logic
        document.querySelectorAll(".star-rating").forEach(container => {
            const stars = container.querySelectorAll(".star");
            const rating = parseFloat(container.getAttribute("data-rating"));

            stars.forEach((star, index) => {
                const value = index + 1;

                if (value <= Math.floor(rating)) {
                    star.innerHTML = "&#9733;";
                    star.style.color = "gold";
                } else if (value === Math.ceil(rating) && rating % 1 !== 0) {
                    const percentage = (rating % 1) * 100;
                    star.innerHTML = "&#9733;";
                    star.style.color = "gold";
                    star.style.backgroundImage = `linear-gradient(90deg, gold ${percentage}%, #ccc ${percentage}%)`;
                    star.style.webkitBackgroundClip = "text";
                    star.style.color = "transparent";
                    star.style.transition = "background-image 0.3s ease-in-out";
                } else {
                    star.innerHTML = "&#9733;";
                    star.style.color = "rgb(204, 204, 204)";
                }
            });
        });
    });
</script>