<div class="container d-flex flex-column justify-content-top" style="height: 100%">


    <div class="row {{$step == 1 ? "form-row-info-active" : ""}} mt-16 d-flex flex-column">
        <p class="mb-2" data-toggle="tooltip" title="Set name for this estimation. Maybe name of project or client's company? - This field is not provided to the LLM">
            1. Name
        </p>
        <p class="mb-2 {{ $quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,1) ? "form-row-list-info-rejected" : ""}}"  data-toggle="tooltip" title="Understanding the primary purpose of the application helps in identifying the core functionalities that need to be developed.
Information about the business or problem domain could influence the choice of technology and architecture.">
            2. Project Goals and Objectives
        </p>
        <p class="mb-5 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,2) ? "form-row-list-info-rejected" : ""}}" data-toggle="tooltip" title="A detailed list of features, categorized by priority (must-have, nice-to-have).
For complex features, any available mock-ups or user stories would be helpful.">
            3. Feature List
        </p>

    </div>
    <div class="row {{$step == 2 ? "form-row-info-active" : ""}}">

        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,3) ? "form-row-list-info-rejected" : ""}}" data-toggle="tooltip" title="Details about different user types and their interactions with the application can affect both the complexity and the security aspects of the project.">
            4. User Roles and Permissions
        </p>
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,4) ? "form-row-list-info-rejected" : ""}}"  data-toggle="tooltip" title="Information on any third-party services or APIs the application needs to integrate with, along with available documentation.">
            5. Integration Points
        </p>
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,5) ? "form-row-list-info-rejected" : ""}}" data-toggle="tooltip" title="Understanding the data structure, storage needs, and any specific data processing requirements (such as big data analysis, real-time processing).">
            6. Data Management:
        </p>
        <p class="mb-5 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,6) ? "form-row-list-info-rejected" : ""}}" data-toggle="tooltip" title="Insights into the expected look and feel of the application, responsiveness, and any design guidelines or prototypes available.">
            7. UI/UX Design Requirements
        </p>


    </div>
    <div  class="row {{$step == 3 ? "form-row-info-active" : ""}}">
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,7) ? "form-row-list-info-rejected" : ""}}"   data-toggle="tooltip" title="Details on the expected deployment environment, including cloud services, server specifications, or containerization requirements.">
            8. Deployment Environment
        </p>
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,8) ? "form-row-list-info-rejected" : ""}}"  data-toggle="tooltip" title="Expected load, performance criteria, and scalability expectations for the future.">
            9. Scalability and Performance Requirements
        </p>
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,9) ? "form-row-list-info-rejected" : ""}}"  data-toggle="tooltip" title="Understanding long-term plans for the application can impact choices around architecture and technology to facilitate easier updates and maintenance.">
            10. Maintenance and Update Plans
        </p>
        <p class="mb-2 {{$quotationDataId && !\App\Models\VerificationResult::checkIfFieldIsVerified($quotationDataId,10) ? "form-row-list-info-rejected" : ""}}"  data-toggle="tooltip" title="Any preferences or restrictions concerning programming languages, frameworks, or other tools based on existing infrastructures or team expertise.">
            11. Tools and Technologies Preferences
        </p>

    </div>
    <div class="row mt-16">
        <p class="mb-2"   data-toggle="tooltip" title="Details on the expected deployment environment, including cloud services, server specifications, or containerization requirements.Any preferences or restrictions concerning programming languages, frameworks, or other tools based on existing infrastructures or team expertise.">
            Advices
        </p>
    </div>
</div>


@push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endpush
