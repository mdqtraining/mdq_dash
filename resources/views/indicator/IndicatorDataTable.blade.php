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
                                    <td>{{ \Carbon\Carbon::parse($indicator->created_at)->format('d-m-Y') }}</td>

                                    <td class="text-right pr-20">
                                        <div class="task_view">
                                            <div class="dropdown">
                                                <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle"
                                                    type="link" id="dropdownMenuLink-{{ $indicator->id }}"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-options-vertical icons"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" tabindex="0">
                                                    <a href="{{route('indicator.view',$indicator->id)}}" class="dropdown-item"><i class="fa fa-eye mr-2"></i>View</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('indicator.edit', $indicator->id) }}"><i
                                                            class="fa fa-edit mr-2"></i>Edit</a>
                                                    <form action="{{ route('indicator.destroy', $indicator->id) }}"
                                                        method="POST" class="d-inline delete-form">
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
                                <td colspan="7">No records found</td>
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
                        <select class="custom-select custom-select-sm form-control form-control-sm"
                            style="height: 35px; width: 70px;"
                            onchange="window.location.href = '?per_page=' + this.value;">
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
                <div class="dataTables_info" id="leads-table_info" role="status" aria-live="polite"
                    style="white-space: nowrap; padding: 0px !important;">
                    Showing 1 to {{ $indicators->count() }} of {{ $indicators->count() }} entries
                </div>
            </div>

            <!-- Pagination Section -->
            <div>
                <div class="dataTables_paginate paging_simple_numbers" id="leads-table_paginate"
                    style="display: flex; align-items: center;">
                    <ul class="pagination" style="margin: 0; display: flex; list-style: none; padding: 0;">
                        <!-- Previous Button -->
                        <li class="paginate_button page-item " id="leads-table_previous" style="margin-right: 5px;">
                            <a href="#" class="page-link">Previous</a>
                        </li>


                        <li class="paginate_button page-item active " style="margin-right: 5px;">
                            <a href="#" class="page-link"> 1</a>
                        </li>


                        <!-- Next Button -->
                        <li class="paginate_button page-item" id="leads-table_next">
                            <a href="#" class="page-link">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-indicator").forEach(button => {
            button.addEventListener("click", function () {
                let indicatorId = this.getAttribute("data-id");

                if (confirm("Are you sure you want to delete this record?")) {
                    fetch(`/account/indicator/delete/${indicatorId}`, {
                        method: "POST",  // Send POST request (not DELETE)
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ _method: "DELETE" }) // Laravel method spoofing
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