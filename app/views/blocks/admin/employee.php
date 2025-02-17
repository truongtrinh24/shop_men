<div class="d-flex mb-3 justify-content-around">
    <input style="width: 300px;" type="text" class="form-control" placeholder="Search Employee"
        aria-label="Search Employee" aria-describedby="search-employee-icon" id="search-employee-input"
        onkeyup="searchEmployee()">
    
    <button class="btn btn-secondary ml-5" type="button" data-bs-toggle='modal' data-bs-target='#formInsertEmployee' onclick="openInsertEmployeeModal()">Insert Employee</button>
</div>
<div class="container" id="allEmployee">
    <nav>
        <ul class="pagination d-flex justify-content-center ">
            <li class="page-item">
                <a onclick="load_prev_pageEmployee()" class="page-link  text-dark fs-3" aria-label="Previous"
                    style="cursor:pointer;">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <span class="page-link text-dark fw-semibold"> <span id="current_pageEmployee"
                        class="text-primary"></span>/<span id="total_pagesEmployee"></span></span>
            </li>
            <li class="page-item">
                <a onclick="load_next_pageEmployee()" class="page-link  text-dark fs-3" aria-label="Next"
                    style="cursor:pointer;">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <table class="table table-striped text-center">
        <thead>
            <th>Employee_ID</th>
            <th>Employee's Name</th>
            <th>Employee's Phone</th>
            <th>Employee's Address</th>
            <th>Employee Email</th>
            <th>Operations</th>
        </thead>
        <tbody id="dataEmployee">
        </tbody>
    </table>
</div>

<!-- Detail Modal -->
<div class="modal" id="formDetailEmployee" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Employee's Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="employeeDetail" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal" id="formUpdateEmployee" tabindex="-1" aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEmployeeModalLabel">Update Employee</h5>
            </div>
            <div class="modal-body">
                <div id="employeeUpdate" class="text-center"></div>
                <input type="hidden" id="employeeId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="updateEmployee()">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Insert Modal -->
<div class="modal" id="formInsertEmployee" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertModalLabel">Employee's Insert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="employeeInsert" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="insertEmployee()">Insert</button>
            </div>
        </div>
    </div>
</div>