<x-app-layout>
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card text-center sm:rounded-lg shadow-sm d-flex flex-column">
                        <img class="card-img-top" style="width: 100%;height: 10vw;object-fit:cover;" src="{{ asset('quotationImages/test.png') }}" alt="Card image cap">
                        <div class="card-body d-flex flex-column">
                            <div class="card-title mb-4 mt-2" style="font-size: x-large"><b>{{ $quotationData->name }}</b></div>
                            <hr>
                            <div class="card-text mb-3 mt-3" style="font-size: larger" >Status: <span class="{{\App\Enums\QuotationStatus::getStatusColorClass($quotationData->status)}}" data-placement="right" data-toggle="tooltip" title="{{\App\Enums\QuotationStatus::getStatusDescription($quotationData->status)}}">{{ \App\Enums\QuotationStatus::getStatusNicename($quotationData->status) }}</span></div>
                            <div class="card-text mb-1 mt-1" style="font-size: small">Created at: {{ $quotationData->created_at->format('m/d/Y') }}</div>

                            <div class="card-text mb-1 mt-1" style="font-size: small">Updated at: {{ $quotationData->updated_at->format('m/d/Y') }}</div>


                        </div>
                    </div>

                    <div class="mt-5 card text-center sm:rounded-lg shadow-sm d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <div class="card-title mb-4 mt-2" style="font-size: x-large; display: flex; justify-content: center;">
                                <b class="">Project Data</b>
                            </div>

                            <hr>
                            <ul class="link-list mt-4 mb-4">
                                <!-- First Row -->
                                <li><a class="px-2"  href="#" data-toggle="modal" data-target="#dataModal" data-field="objectives" ><span style="font-size: large" class="badge badge-secondary custom-badge">1. Project Goals and Objectives</span></a></li>
                                <li><a class="px-2"  href="#" data-toggle="modal" data-target="#dataModal" data-field="features" ><span style="font-size: large" class="badge badge-secondary custom-badge">2. Features List</span></a></li>
                            </ul>
                            <hr>
                            <ul class="link-list mt-4 mb-4">
                                <!-- Second Row -->
                                <li><a class="" href="#" data-toggle="modal" data-target="#dataModal" data-field="roles" ><span style="font-size: large" class="badge badge-secondary custom-badge">3. User Roles and Permissions</span></a></li>
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="integrations" ><span style="font-size: large" class="badge badge-secondary custom-badge">4. Integration Points</span></a></li>
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="db" ><span style="font-size: large" class="badge badge-secondary custom-badge">5. Data Management</span></a></li>
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="design" ><span style="font-size: large" class="badge badge-secondary custom-badge">6. UI/UX Design Requirements</span></a></li>
                            </ul>
                            <hr>
                            <ul class="link-list mt-4 mb-4">
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="deploy" ><span style="font-size: large" class="badge badge-secondary custom-badge">7. Deployment Environment</span></a></li>
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="scalability" ><span style="font-size: large" class="badge badge-secondary custom-badge">8. Scalability and Performance Requirements</span></a></li>
                                <li><a class="" href="#" data-toggle="modal"  data-target="#dataModal" data-field="maintenance" ><span style="font-size: large" class="badge badge-secondary custom-badge">9. Maintenance and Update Plans</span></a></li>
                                <li><a class="" href="#" data-toggle="modal" data-target="#dataModal" data-field="tech" ><span style="font-size: large" class="badge badge-secondary custom-badge">10. Tools and Technologies Preferences</span></a></li>
                            </ul>
                            <hr>
                            <div class="flex mt-4" style=" display: flex; justify-content: center">
                            <button  {{$quotationData->status == \App\Enums\QuotationStatus::ESTIMATION_IN_PROGRESS->value ? 'disabled ' : '' }}style="width: fit-content;" class="btn btn-primary">Edit data</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <div class="card text-center rounded sm:rounded-lg shadow-sm">
                        <div class="card-body">
                            @if($quotationData->status == 'done')
                            {{--tutaj wynik estymacji jakoś fajnie przedstawic --}}
                                <form action="{{ route('yourEstimationProcessRoute') }}" method="POST">
                                    @csrf
                                    <!-- Add your form elements here -->
                                    <button type="submit" class="btn btn-primary">Start Estimation</button>
                                </form>
                            @elseif($quotationData->status == 'estimation_in_progress')
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <h1 class="mt-3 ml-3 mr-3 mb-5" style="font-size: x-large">Estimation is processing...</h1>
                                <hr class="mb-2">
                                <form id="estimationForm">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Project Side</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Select which part of the project you would like to estimate.</p>
                                        <div class="d-flex justify-content-between mt-3" style="padding-left: 10vw; padding-right: 10vw" >
                                            @foreach(['Frontend', 'Backend', 'Both'] as $option)
                                                <div class="custom-control custom-radio">
                                                    <input disabled type="radio" class="custom-control-input" name="project_side" id="project_side_{{ strtolower($option) }}" value="{{ $option }}">
                                                    <label class="custom-control-label" for="project_side_{{ strtolower($option) }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Team Experience</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Determine the experience level of the team that will handle the project.</p>
                                        <div class="d-flex justify-content-between mt-3" style="padding-left: 10vw; padding-right: 10vw" >
                                            @foreach(['Junior', 'Mid', 'Senior'] as $option)
                                                <div class="custom-control custom-radio">
                                                    <input disabled type="radio" class="custom-control-input" name="team_experience" id="team_experience_{{ strtolower($option) }}" value="{{ $option }}">
                                                    <label class="custom-control-label"for="team_experience_{{ strtolower($option) }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Unit Test Buffer</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Determine whether the team should have time added to the estimate to create unit tests.</p>
                                        <div class="mt-3 custom-control custom-checkbox">
                                            <input disabled type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Meetings with the client</b></label>
                                        <p class="mb-2 ml-5 mr-5" >Indicate whether the estimate should include time for meetings with the client to agree on details or present progress.</p>
                                        <div class="mt-3 custom-control custom-checkbox">
                                            <input disabled type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                                        </div>
                                    </div>
                                    <button type="button" disabled class=" mt-5 btn btn-primary" data-toggle="modal" data-target="#confirmModal">Run estimation</button>
                                </form>
                            @else
                                <h1 class="mt-4 ml-3 mr-3 mb-5" style="font-size: x-large">Complete the required data and start estimating!</h1>
                                <hr class="mb-2">
                                <form id="estimationForm">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Project Side</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Select which part of the project you would like to estimate.</p>
                                        <div class="d-flex justify-content-between mt-3" style="padding-left: 10vw; padding-right: 10vw" >
                                            @foreach(['Frontend', 'Backend', 'Both'] as $option)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="project_side" id="project_side_{{ strtolower($option) }}" value="{{ strtolower($option)  }}">
                                                    <label class="custom-control-label" for="project_side_{{ strtolower($option) }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Team Experience</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Determine the experience level of the team that will handle the project.</p>
                                        <div class="d-flex justify-content-between mt-3" style="padding-left: 10vw; padding-right: 10vw" >
                                            @foreach(['Junior', 'Mid', 'Senior'] as $option)
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" name="team_experience" id="team_experience_{{ strtolower($option) }}" value="{{ strtolower($option) }}">
                                                    <label class="custom-control-label" for="team_experience_{{ strtolower($option) }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                    <div class="form-group">
                                        <label class="mt-2" style="font-size: larger; "><b>Unit Test Buffer</b></label>
                                        <p class="mb-2  ml-5 mr-5" >Determine whether the team should have time added to the estimate to create unit tests.</p>
                                        <div class="mt-3 custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"  name="unit_test_buffer" id="unit_test_buffer">
                                            <label class="custom-control-label" for="unit_test_buffer">Include unit tests</label>
                                        </div>
                                    </div>
                                    <hr class="mt-4 mb-2">
                                        <div class="form-group">
                                            <label class="mt-2" style="font-size: larger; "><b>Meetings with the client</b></label>
                                            <p class="mb-2 ml-5 mr-5" >Indicate whether the estimate should include time for meetings with the client to agree on details or present progress.</p>
                                                <div class="mt-3 custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="meetings_buffer" name="meetings_buffer">
                                                    <label class="custom-control-label" for="meetings_buffer">Include meetings</label>
                                    </div>
                                        </div>
                                    <button type="button" class=" mt-5 btn btn-primary" data-toggle="modal" data-target="#confirmModal">Run estimation</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Confirm Estimation Parameters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- The selected options will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmEstimation">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b class="modal-title" id="dataModalLabel">Project Data Details</b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="dataContent">Some content</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('confirmEstimation').addEventListener('click', function() {
                // Submit the form here.
                document.getElementById('estimationForm').submit();
            });

            $('#confirmModal').on('show.bs.modal', function (event) {
                var modal = $(this);
                // Example: Add selected Project Side to the modal
                var projectSide = $('input[name="project_side"]:checked').val();
                var experience = $('input[name="team_experience"]:checked').val()
                var unitTests = $('input[name="unit_test_buffer"]:checked').val()
                var meetings = $('input[name="meetings_buffer"]:checked').val()
                alert(projectSide);
                // Generate result message based on input values
                var resultMessage = '<p>';
                if (projectSide === 'frontend') {
                    resultMessage = resultMessage + 'Estimation for all <b>frontend</b> tasks. ';
                } else if (projectSide === 'backend') {
                    resultMessage = resultMessage + 'Estimation for all <b>backend</b> tasks. ';
                }else{
                    resultMessage = resultMessage + 'Estimation for all <b>backend</b> and <b>frontend</b> tasks. '
                }
                resultMessage = resultMessage + '<br>';

                switch (experience){

                    case 'junior':
                        resultMessage = resultMessage + 'The project team generally has a <b>junior</b> level of experience. ';
                        break;
                    case 'mid':
                        resultMessage = resultMessage + 'The project team generally has a <b>mid</b> level of experience. ';
                        break;
                    case 'senior':
                        resultMessage = resultMessage + 'The project team generally has a <b>senior</b> level of experience. ';
                        break;
                    default:
                        resultMessage = resultMessage + '';
                        break;
                }
                resultMessage = resultMessage + '<br>';
                if (unitTests) {
                    resultMessage =  resultMessage + 'Estimation <b>with buffer</b> for unit tests.';
                }else{
                    resultMessage =  resultMessage +  'Estimation <b>without buffer</b> for unit tests.'
                }
                resultMessage = resultMessage + '<br>';
                if (meetings) {
                    resultMessage =  resultMessage + 'Estimation <b>with buffer</b> for meetings with clients.';
                }else{
                    resultMessage =  resultMessage +  'Estimation <b>without buffer</b> for meetings with clients.'
                }
                resultMessage = resultMessage + '</p>';


                modal.find('.modal-body').html('<div class=" text-center">' + resultMessage + '</div>');
                // Add more parameters as needed...
            });
        </script>

        <script>
            $(document).ready(function() {
                $('a[data-toggle="modal"]').click(function(event) {
                    var fieldName = $(this).attr('data-field'); // Get the field name

                    // Assuming you have the QuotationData JSON object available
                    let quotationData = @json($quotationData);
                    var fieldValue = quotationData[fieldName]; // Get the field value using the field name

                    // Update the modal’s title and content
                    $('#dataModalLabel').text(fieldName.replace('_', ' ').toUpperCase()); // Simple text formatting
                    $('#dataContent').text(fieldValue);

                    // Now Bootstrap will automatically show the modal because of the data-toggle attribute
                });
            });
        </script>

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

    @endpush
</x-app-layout>
