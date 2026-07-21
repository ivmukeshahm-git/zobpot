# Requirements Document

## Introduction

The Admin Internship Management System is a feature for the Laravel-based admin panel that enables administrators to create, manage, and track internship programs. The system provides a multi-step form interface for creating internships with comprehensive details including company information, scheduling, skills requirements, and program descriptions. The feature integrates with existing database tables for companies and categories while maintaining a dedicated internship data store.

## Glossary

- **Admin_Panel**: The administrative interface of the Laravel application where authorized users manage system data
- **Internship_System**: The complete internship management feature including database, controllers, views, and business logic
- **Internship_Form**: The multi-step form interface for creating and editing internship records
- **Company_Dropdown**: A select input populated with company names from the users table filtered by company role
- **Category_Dropdown**: A select input populated with category names from the job_category table
- **Internship_Controller**: The Laravel controller class in the Admin namespace that handles internship CRUD operations
- **Internship_Model**: The Eloquent model representing the tbl_internship database table
- **Batch_Days**: A JSON structure storing weekly schedule information with day names and time ranges
- **Create_View**: The Blade template file for the internship creation form (create.blade.php)
- **Index_View**: The Blade template file for listing internships (internship.blade.php)
- **Database_Migration**: The migration file that creates the tbl_internship table structure
- **Form_Validator**: The Laravel validation logic that ensures data integrity before database insertion
- **Skills_Input**: A tag-based input component for entering multiple required skills
- **Eligibility_Input**: A tag-based input component for entering multiple eligibility criteria
- **Rich_Text_Editor**: A Quill.js editor instance for formatted text input fields

## Requirements

### Requirement 1: Internship Database Storage

**User Story:** As an administrator, I want internship data stored in a dedicated database table, so that I can persist and retrieve internship information reliably.

#### Acceptance Criteria

1. THE Internship_System SHALL store all internship records in the tbl_internship table
2. THE Database_Migration SHALL create a table with columns for internship_title, category, company_id, company_website, mode, location, stipend, openings, duration, total_weeks, total_hours, start_date, end_date, application_deadline, batch_days (JSON), skills (text), eligibility_criteria (text), internship_description (text), module_brief_description (text), internship_objective (text), internship_outcome (text), registration_fees, gst_percentage, gst_amount, final_amount, and timestamps
3. THE tbl_internship table SHALL use an auto-incrementing id as the primary key
4. THE tbl_internship table SHALL store batch_days as a JSON column with the format: [{"day": "Monday", "start_datetime": "2024-01-01T09:00", "end_datetime": "2024-01-01T17:00"}]
5. THE Database_Migration SHALL set nullable constraints on optional fields: category, company_id, company_website, mode, location, stipend, openings, duration, total_weeks, total_hours, start_date, end_date, application_deadline, batch_days, skills, eligibility_criteria, internship_description, module_brief_description, internship_objective, internship_outcome, registration_fees, gst_percentage, gst_amount, final_amount

### Requirement 2: Company Data Integration

**User Story:** As an administrator, I want to select companies from existing user records, so that I can associate internships with registered companies.

#### Acceptance Criteria

1. THE Company_Dropdown SHALL populate options from the users table WHERE role equals 'company'
2. THE Company_Dropdown SHALL display the company name as the visible option text
3. THE Company_Dropdown SHALL use the user id as the option value
4. WHEN the administrator selects a company, THE Internship_Form SHALL store the company_id in the internship record
5. THE Internship_Controller SHALL retrieve company data using an Eloquent relationship or query builder

### Requirement 3: Category Data Integration

**User Story:** As an administrator, I want to select internship categories from existing category records, so that I can classify internships consistently with the job system.

#### Acceptance Criteria

1. THE Category_Dropdown SHALL populate options from the tbl_job_category table
2. THE Category_Dropdown SHALL display the category_nm field as the visible option text
3. THE Category_Dropdown SHALL use the category_id as the option value
4. WHEN the administrator selects a category, THE Internship_Form SHALL store the category_id in the internship record
5. THE Internship_Controller SHALL retrieve category data using an Eloquent relationship or query builder

### Requirement 4: Internship Controller Implementation

**User Story:** As a developer, I want a dedicated controller in the Admin namespace, so that internship operations follow the application's architectural patterns.

#### Acceptance Criteria

1. THE Internship_System SHALL include an InternshipController class in the App\Http\Controllers\Admin namespace
2. THE Internship_Controller SHALL extend the base Controller class
3. THE Internship_Controller SHALL implement an index method that returns the Index_View
4. THE Internship_Controller SHALL implement a create method that returns the Create_View with company and category data
5. THE Internship_Controller SHALL implement a store method that validates and persists internship data
6. THE Internship_Controller SHALL implement an edit method that retrieves and displays existing internship data
7. THE Internship_Controller SHALL implement an update method that validates and updates internship records
8. THE Internship_Controller SHALL implement a destroy method that deletes internship records
9. WHEN validation fails in the store or update methods, THE Internship_Controller SHALL return validation errors with HTTP status 422

### Requirement 5: Form Validation

**User Story:** As an administrator, I want the system to validate my input, so that I cannot submit incomplete or invalid internship data.

#### Acceptance Criteria

1. THE Form_Validator SHALL require internship_title as a non-empty string with maximum length 255
2. THE Form_Validator SHALL require category_id as a valid integer that exists in tbl_job_category
3. THE Form_Validator SHALL require company_id as a valid integer that exists in the users table
4. THE Form_Validator SHALL validate company_website as a valid URL format when provided
5. THE Form_Validator SHALL require mode as one of: 'Online', 'Offline', or 'Hybrid'
6. THE Form_Validator SHALL require location as a non-empty string
7. THE Form_Validator SHALL validate stipend as a positive decimal number when provided
8. THE Form_Validator SHALL require openings as a positive integer
9. THE Form_Validator SHALL require duration as a non-empty string
10. THE Form_Validator SHALL require total_weeks as a positive integer
11. THE Form_Validator SHALL require total_hours as a positive integer
12. THE Form_Validator SHALL require start_date as a valid date
13. THE Form_Validator SHALL require end_date as a valid date that is after or equal to start_date
14. THE Form_Validator SHALL require application_deadline as a valid date that is before or equal to start_date
15. THE Form_Validator SHALL validate batch_days as valid JSON when provided
16. THE Form_Validator SHALL require internship_description as a non-empty string
17. THE Form_Validator SHALL require module_brief_description as a non-empty string
18. THE Form_Validator SHALL require internship_objective as a non-empty string
19. THE Form_Validator SHALL require internship_outcome as a non-empty string

### Requirement 6: Create View Implementation

**User Story:** As an administrator, I want a multi-step form to create internships, so that I can enter comprehensive information in an organized manner.

#### Acceptance Criteria

1. THE Create_View SHALL display a 5-step wizard interface using the bs-stepper library
2. THE Create_View SHALL include Step 1 (Basic Information) with fields: internship_title, category_id, company_id, company_website, mode, location, stipend, openings
3. THE Create_View SHALL include Step 2 (Duration & Schedule) with fields: duration, total_weeks, total_hours, start_date, end_date, application_deadline, batch_days
4. THE Create_View SHALL include Step 3 (Skills & Eligibility) with fields: skills, eligibility_criteria
5. THE Create_View SHALL include Step 4 (Program Details) with fields: internship_description, module_brief_description, internship_objective, internship_outcome
6. THE Create_View SHALL include Step 5 (Preview) that displays all entered data for review
7. THE Create_View SHALL use Select2 library for the Company_Dropdown and Category_Dropdown
8. THE Create_View SHALL use Quill.js Rich_Text_Editor for description fields
9. THE Create_View SHALL implement tag-based input for Skills_Input and Eligibility_Input
10. THE Create_View SHALL include a batch days selector that dynamically generates date/time inputs for selected days
11. WHEN the administrator clicks Next, THE Create_View SHALL validate the current step before proceeding
12. WHEN the administrator clicks Previous, THE Create_View SHALL navigate to the previous step without validation
13. WHEN the administrator submits the form, THE Create_View SHALL send a POST request to the store route with all form data

### Requirement 7: Index View Implementation

**User Story:** As an administrator, I want to view a list of all internships, so that I can manage existing internship records.

#### Acceptance Criteria

1. THE Index_View SHALL display a table listing all internship records
2. THE Index_View SHALL show columns for: internship_title, company name, category name, mode, location, openings, start_date, application_deadline, and actions
3. THE Index_View SHALL include a "Create New Internship" button that navigates to the Create_View
4. THE Index_View SHALL include Edit and Delete action buttons for each internship record
5. THE Index_View SHALL use DataTables library for pagination, sorting, and searching
6. WHEN the administrator clicks Edit, THE Index_View SHALL navigate to the edit route with the internship id
7. WHEN the administrator clicks Delete, THE Index_View SHALL display a confirmation dialog before deletion
8. WHEN deletion is confirmed, THE Index_View SHALL send a DELETE request to the destroy route

### Requirement 8: Form JavaScript Functionality

**User Story:** As an administrator, I want interactive form controls, so that I can efficiently enter internship data.

#### Acceptance Criteria

1. THE Create_View SHALL initialize Select2 on company and category dropdowns with search functionality
2. THE Create_View SHALL initialize Quill.js editors on all description fields
3. WHEN the administrator types a skill and presses Enter in Skills_Input, THE Create_View SHALL create a skill tag and add it to the display
4. WHEN the administrator clicks the remove icon on a skill tag, THE Create_View SHALL remove that skill from the list
5. WHEN the administrator types an eligibility criterion and presses Enter in Eligibility_Input, THE Create_View SHALL create an eligibility tag and add it to the display
6. WHEN the administrator clicks the remove icon on an eligibility tag, THE Create_View SHALL remove that criterion from the list
7. WHEN the administrator selects days in the batch days selector, THE Create_View SHALL generate a table row for each selected day with start_datetime and end_datetime inputs
8. WHEN the administrator deselects a day in the batch days selector, THE Create_View SHALL remove the corresponding table row
9. WHEN the administrator clicks the remove button on a batch day row, THE Create_View SHALL remove that row and deselect the day
10. WHEN the administrator navigates to the Preview step, THE Create_View SHALL populate preview fields with current form values
11. WHEN the administrator submits the form, THE Create_View SHALL serialize all form data including tags, rich text content, and batch days JSON
12. WHEN the form submission succeeds, THE Create_View SHALL display a success message and redirect to the Index_View
13. WHEN the form submission fails, THE Create_View SHALL display validation errors next to the relevant fields

### Requirement 9: Data Persistence

**User Story:** As an administrator, I want all form data saved to the database, so that internship information is permanently stored.

#### Acceptance Criteria

1. WHEN the administrator submits the Internship_Form, THE Internship_Controller SHALL insert a new record into tbl_internship with all form field values
2. THE Internship_Controller SHALL convert skills tags to a comma-separated string or JSON array before storage
3. THE Internship_Controller SHALL convert eligibility criteria tags to a comma-separated string or JSON array before storage
4. THE Internship_Controller SHALL store batch_days as a valid JSON array
5. THE Internship_Controller SHALL extract HTML content from Rich_Text_Editor fields and store it in text columns
6. THE Internship_Controller SHALL set created_at and updated_at timestamps automatically
7. WHEN database insertion succeeds, THE Internship_Controller SHALL return a success response with HTTP status 200
8. WHEN database insertion fails, THE Internship_Controller SHALL return an error response with HTTP status 500

### Requirement 10: Route Configuration

**User Story:** As a developer, I want properly configured routes, so that the internship feature is accessible through the admin panel.

#### Acceptance Criteria

1. THE Internship_System SHALL register a route for GET /admin/internship that maps to InternshipController@index
2. THE Internship_System SHALL register a route for GET /admin/internship/create that maps to InternshipController@create
3. THE Internship_System SHALL register a route for POST /admin/internship that maps to InternshipController@store
4. THE Internship_System SHALL register a route for GET /admin/internship/{id}/edit that maps to InternshipController@edit
5. THE Internship_System SHALL register a route for PUT /admin/internship/{id} that maps to InternshipController@update
6. THE Internship_System SHALL register a route for DELETE /admin/internship/{id} that maps to InternshipController@destroy
7. THE Internship_System SHALL apply the 'auth' middleware to all internship routes
8. THE Internship_System SHALL apply the 'admin' middleware to all internship routes to restrict access to administrators

### Requirement 11: Internship Model

**User Story:** As a developer, I want an Eloquent model for internships, so that I can interact with internship data using Laravel's ORM.

#### Acceptance Criteria

1. THE Internship_System SHALL include an Internship model class in the App\Models namespace
2. THE Internship_Model SHALL specify 'tbl_internship' as the table name
3. THE Internship_Model SHALL define fillable attributes for all internship fields
4. THE Internship_Model SHALL cast batch_days as 'array' to automatically handle JSON serialization
5. THE Internship_Model SHALL define a belongsTo relationship to the User model for the company association
6. THE Internship_Model SHALL define a belongsTo relationship to the JobCategory model for the category association
7. THE Internship_Model SHALL use timestamps for created_at and updated_at

### Requirement 12: Financial Calculation Fields

**User Story:** As an administrator, I want to store registration fees and GST calculations, so that I can track internship costs.

#### Acceptance Criteria

1. THE Internship_Form SHALL include optional fields for registration_fees, gst_percentage, gst_amount, and final_amount
2. WHEN the administrator enters registration_fees and gst_percentage, THE Create_View SHALL calculate gst_amount as (registration_fees * gst_percentage / 100)
3. WHEN gst_amount is calculated, THE Create_View SHALL calculate final_amount as (registration_fees + gst_amount)
4. THE Form_Validator SHALL validate registration_fees as a positive decimal number when provided
5. THE Form_Validator SHALL validate gst_percentage as a decimal between 0 and 100 when provided
6. THE Internship_Controller SHALL store all financial fields in the database when provided

### Requirement 13: Error Handling

**User Story:** As an administrator, I want clear error messages, so that I can correct issues when creating internships.

#### Acceptance Criteria

1. WHEN validation fails, THE Internship_Controller SHALL return a JSON response with field-specific error messages
2. WHEN a database error occurs, THE Internship_Controller SHALL log the error and return a user-friendly message
3. WHEN a company_id does not exist in the users table, THE Form_Validator SHALL return an error message "Selected company is invalid"
4. WHEN a category_id does not exist in tbl_job_category, THE Form_Validator SHALL return an error message "Selected category is invalid"
5. WHEN end_date is before start_date, THE Form_Validator SHALL return an error message "End date must be after or equal to start date"
6. WHEN application_deadline is after start_date, THE Form_Validator SHALL return an error message "Application deadline must be before or equal to start date"
7. THE Create_View SHALL display validation errors in red text below the corresponding form fields

### Requirement 14: Data Retrieval for Dropdowns

**User Story:** As an administrator, I want dropdowns populated with current data, so that I can select from available companies and categories.

#### Acceptance Criteria

1. WHEN the Create_View loads, THE Internship_Controller SHALL query the users table for records WHERE role = 'company'
2. WHEN the Create_View loads, THE Internship_Controller SHALL query tbl_job_category for all active categories
3. THE Internship_Controller SHALL pass company data to the Create_View as a collection or array
4. THE Internship_Controller SHALL pass category data to the Create_View as a collection or array
5. THE Create_View SHALL render company options using Blade syntax to iterate over the company collection
6. THE Create_View SHALL render category options using Blade syntax to iterate over the category collection
7. WHEN no companies exist with role 'company', THE Company_Dropdown SHALL display a "No companies available" option
8. WHEN no categories exist, THE Category_Dropdown SHALL display a "No categories available" option
