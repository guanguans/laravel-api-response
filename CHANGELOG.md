<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="1.0.0-rc3"></a>
## [1.0.0-rc3] - 2024-10-28
### CI
- **composer:** Update composer-require-checker

### Chores
- **release:** 1.0.0-rc2

### Code Refactoring
- **concerns:** rename ConcreteHttpStatusMethods to ConcreteHttpStatus

### Docs
- **api:** Add response structure documentation
- **readme:** Add ShouldReturnJsonRenderUsing example

### Test
- **rename:** rename test files
- **types:** add tests for LaravelDataTypesTest.php


<a name="1.0.0-rc2"></a>
## [1.0.0-rc2] - 2024-10-25
### Chores
- **commit:** Update project dependencies
- **composer:** Add phpmnd package
- **release:** 1.0.0-rc1

### Code Refactoring
- **api:** replace magic numbers with constants
- **pipes:** update StatusCodePipe to handle success/error codes

### Docs
- **api-response:** Add features section

### Features
- **ApiResponse:** improve JSON response options
- **rendering:** Refactor ApiPathsRenderUsing to include 'only' and 'except' parameters

### Test
- Add snapshot update command and new RoleUser model
- **Feature:** update LaravelDataTypesTest
- **commit:** Update ApiResponse, ApiResponseContract, and related classes


<a name="1.0.0-rc1"></a>
## [1.0.0-rc1] - 2024-08-28
### Chores
- **dependencies:** update phpstan to version 1.12
- **release:** 1.0.0-beta3

### Code Refactoring
- **models:** simplify relationship methods

### Features
- **exception-pipes:** add HttpResponseExceptionPipe and ResponsableExceptionPipe
- **tests:** update HTTP status checks for API responses

### Test
- **refactor:** rename test directories and update paths


<a name="1.0.0-beta3"></a>
## [1.0.0-beta3] - 2024-08-27
### Bug Fixes
- **api-response:** rename HideMessageExceptionPipe to HideOriginalMessageExceptionPipe

### Chores
- **release:** 1.0.0-beta2

### Code Refactoring
- implement __set_state method using SetStateable traitReplace the explicit __set_state method with the SetStateable trait in theApiPathsRenderUsingFactory class to improve code reuse and readability.
- **ApiResponse:** inline pipeline instantiates and extracts destination closure
- **ApiResponseServiceProvider:** simplify registration methods
- **api-response:** rename WithHeadersExceptionPipe to SetHeadersExceptionPipe
- **api-response:** handle authentication and hide sensitive errors
- **api-response:** optimize status code validation and error handling
- **api-response:** remove default data pipe to simplify response data handling
- **render-usings:** rename classes and adjust naming convention

### Features
- remove invalid argument exception and runtime exception classes
- add null data pipe and scalar data pipe classes to process data
- **ApiResponseServiceProvider:** modifying exception handling factory classes and methods
- **Facades:** rename ApiResponse to ApiResponseFacade
- **api-response:** add exception pipes for headers and error handling
- **api-response:** add exception pipes for status code and message settingAdd new exception pipes to handle the setting of status codes and messages uniformly across exceptions. This enhances the error handling in the API by allowing customizable response formatting through `SetCodeExceptionPipe` and `SetMessageExceptionPipe`, providing better control over the error messages and codes returned.
- **tests:** add test models and seeder for API responsesAdded model classes and a seeder for database tables to expand testing coverage of API responses. This includes the creation of models for Country, User, Post, Comment, Role, and Tag entities, along with a seeder class to populate these models with test data.

### Test
- **api:** update exception pipes and response handling
- **api-response:** update tests for model and resource data types

### BREAKING CHANGE

Exception handling logic might need to be updated to accommodate the
new pipes for proper header and error handling.


<a name="1.0.0-beta2"></a>
## [1.0.0-beta2] - 2024-08-23
### Bug Fixes
- **CollectionMacro:** add unshift method to CollectionMacro

### Chores
- **release:** 1.0.0-beta1

### Test
- Remove old success and error response tests
- Add unit tests for ApiResponse functionality


<a name="1.0.0-beta1"></a>
## 1.0.0-beta1 - 2024-08-23
### Bug Fixes
- **api-response:** fix exception handling and improve test coverage

### Chores
- updating configuration and removing useless files
- **release:** 2.0.0-beta1

### Code Refactoring
- Rename Throwable interface and update usage
- **MessagePipe:** rename default parameter and update method logic
- **api:** replace ApiResponse with ApiResponseContract
- **api-response:** rename interface and update bindings
- **pipes:** rename SetStatusCodePipe to StatusCodePipe
- **pipes:** rename DataPipe to DefaultDataPipe and add PaginatorDataPipe
- **render:** restructure render factories and update usage

### Features
- updated code in Pipes and Middleware to optimize the request processing flow
- wip
- build the basic skeleton
- **api-response:** refactor exception handling and removal of exception map
- **ci:** update Laravel version constraints in workflows and composer
- **exception:** add exception handling with pipes
- **exception-pipes:** add HideMessageExceptionPipe
- **exception-pipes:** add validation and HTTP exception pipes

### Test
- Refactor tests and skip unimplemented tests
- **apiResponse:** Refactor API response tests to use instance method


[Unreleased]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc3...HEAD
[1.0.0-rc3]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc2...1.0.0-rc3
[1.0.0-rc2]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc1...1.0.0-rc2
[1.0.0-rc1]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta3...1.0.0-rc1
[1.0.0-beta3]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta2...1.0.0-beta3
[1.0.0-beta2]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta1...1.0.0-beta2
