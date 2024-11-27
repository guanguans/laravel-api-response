<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="1.0.10"></a>
## [1.0.10] - 2024-11-27
### Bug Fixes
- **Pipes:** Handle withoutWrapper method in data structures

### Build
- **deps:** Update ergebnis/license and ergebnis/rector-rules versions
- **deps:** bump codecov/codecov-action from 4 to 5

### Docs
- **readme:** Remove unnecessary detail sections

### Pull Requests
- Merge pull request [#2](https://github.com/guanguans/laravel-api-response/issues/2) from guanguans/dependabot/github_actions/codecov/codecov-action-5


<a name="1.0.9"></a>
## [1.0.9] - 2024-11-12
### Bug Fixes
- **PaginatorDataPipe:** Change data output structure for resources
- **Pipes:** Prevent JsonResource wrapping for paginated data

### Build
- **composer:** Update PHPStan and dependencies version constraints

### CI
- **facade:** Add new PHPDoc annotations and methods in ApiResponseFacade


<a name="1.0.8"></a>
## [1.0.8] - 2024-11-11
### Bug Fixes
- **api-response-facade:** Add castToNull method declaration

### Docs
- **api:** Update response documentation and code examples

### Features
- **Pipes:** Refactor CastDataPipe to improve data casting logic

### Tests
- **LaravelDataTest:** Enhance resource collection tests


<a name="1.0.7"></a>
## [1.0.7] - 2024-11-08
### Bug Fixes
- **CastDataPipe:** Handle null case in dataFor method
- **ErrorPipe:** Enhance error message handling

### Code Refactoring
- **composer:** Rename Dumpable.php to Traits
- **laravel-api-response:** rename Macros to Mixins

### Features
- **JsonResponsableDataPipe:** Add associative option for JSON response

### Performance Improvements
- **Pipes:** Optimize dataFor method type check

### Tests
- **pipes:** Improve pipe handling and add exception test


<a name="1.0.6"></a>
## [1.0.6] - 2024-11-05
### Bug Fixes
- **HasPipes:** Support multiple pipes in before and after methods

### Features
- **HasExceptionPipes:** Add new methods for exception pipe management
- **api-response:** Add Dumpable trait for improved debugging


<a name="1.0.5"></a>
## [1.0.5] - 2024-11-04
### Features
- **ApiResponse:** Add ConcreteCast trait for data casting
- **pipe:** Add CallableDataPipe for processing response data
- **pipes:** Add IterableDataPipe for processing iterable data
- **pipes:** Add CastDataPipe class for data type casting

### Performance Improvements
- **ApiResponse:** Enhance JSON options for response formatting

### Tests
- **iterable-data-pipe:** Update iterable data handling logic


<a name="1.0.4"></a>
## [1.0.4] - 2024-11-03
### Bug Fixes
- **ErrorPipe:** Correct message assignment logic
- **MessagePipe:** Improve error handling messages
- **api:** Change response data to null instead of empty object
- **api-response:** Simplify data structure in response
- **utils:** Rename error code validation methods

### Code Refactoring
- **api:** Remove ResourceCollectionDataPipe class
- **api:** Improve visibility and remove middleware
- **api-response:** rename ToJsonResponseDataPipe to JsonResponsableDataPipe
- **nullDataPipe:** Improve data handling in dataFor method

### Features
- **pipes:** Enhance PaginatorDataPipe to support wrapping data

### Style
- **ExceptionPipes:** Refactor variable naming from data to structure

### Tests
- **LaravelDataTest:** Add tests for pagination wrappers


<a name="1.0.3"></a>
## [1.0.3] - 2024-11-02
### Bug Fixes
- **pipes:** Remove unused parameter from ScalarDataPipe

### Features
- **api-response:** Add ResourceCollectionDataPipe
- **middleware:** Enhance accept header handling

### Tests
- **composer-updater:** improve process creation


<a name="1.0.2"></a>
## [1.0.2] - 2024-10-31
### Bug Fixes
- **ApiResponse:** Fix error code handling in exceptionDestination
- **utils:** Improve Utils class

### Tests
- **commit:** Add new datasets for testing


<a name="1.0.1"></a>
## [1.0.1] - 2024-10-30
### Bug Fixes
- **ExceptionPipes:** fix validation error message
- **Pipes:** Fix error handling in ErrorPipe

### Features
- **api:** Add Localizable trait to ApiResponse

### Tests
- **test:** Add exception tests


<a name="1.0.0"></a>
## [1.0.0] - 2024-10-29
### Docs
- **README:** update usage instructions and add example methods
- **readme:** Update README.md with example of customizing pipe

### Features
- **api:** add JsonResourceDataPipe


<a name="1.0.0-rc3"></a>
## [1.0.0-rc3] - 2024-10-28
### CI
- **composer:** Update composer-require-checker

### Code Refactoring
- **concerns:** rename ConcreteHttpStatusMethods to ConcreteHttpStatus

### Docs
- **api:** Add response structure documentation
- **readme:** Add ShouldReturnJsonRenderUsing example

### Tests
- **rename:** rename test files
- **types:** add tests for LaravelDataTypesTest.php


<a name="1.0.0-rc2"></a>
## [1.0.0-rc2] - 2024-10-25
### Code Refactoring
- **api:** replace magic numbers with constants
- **pipes:** update StatusCodePipe to handle success/error codes

### Docs
- **api-response:** Add features section

### Features
- **ApiResponse:** improve JSON response options
- **rendering:** Refactor ApiPathsRenderUsing to include 'only' and 'except' parameters

### Tests
- Add snapshot update command and new RoleUser model
- **Feature:** update LaravelDataTypesTest
- **commit:** Update ApiResponse, ApiResponseContract, and related classes


<a name="1.0.0-rc1"></a>
## [1.0.0-rc1] - 2024-08-28
### Code Refactoring
- **models:** simplify relationship methods

### Features
- **exception-pipes:** add HttpResponseExceptionPipe and ResponsableExceptionPipe
- **tests:** update HTTP status checks for API responses

### Tests
- **refactor:** rename test directories and update paths


<a name="1.0.0-beta3"></a>
## [1.0.0-beta3] - 2024-08-27
### Bug Fixes
- **api-response:** rename HideMessageExceptionPipe to HideOriginalMessageExceptionPipe

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

### Tests
- **api:** update exception pipes and response handling
- **api-response:** update tests for model and resource data types

### BREAKING CHANGE

Exception handling logic might need to be updated to accommodate the
new pipes for proper header and error handling.


<a name="1.0.0-beta2"></a>
## [1.0.0-beta2] - 2024-08-23
### Bug Fixes
- **CollectionMacro:** add unshift method to CollectionMacro

### Tests
- Remove old success and error response tests
- Add unit tests for ApiResponse functionality


<a name="1.0.0-beta1"></a>
## 1.0.0-beta1 - 2024-08-23
### Bug Fixes
- **api-response:** fix exception handling and improve test coverage

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

### Tests
- Refactor tests and skip unimplemented tests
- **apiResponse:** Refactor API response tests to use instance method


[Unreleased]: https://github.com/guanguans/laravel-api-response/compare/1.0.10...HEAD
[1.0.10]: https://github.com/guanguans/laravel-api-response/compare/1.0.9...1.0.10
[1.0.9]: https://github.com/guanguans/laravel-api-response/compare/1.0.8...1.0.9
[1.0.8]: https://github.com/guanguans/laravel-api-response/compare/1.0.7...1.0.8
[1.0.7]: https://github.com/guanguans/laravel-api-response/compare/1.0.6...1.0.7
[1.0.6]: https://github.com/guanguans/laravel-api-response/compare/1.0.5...1.0.6
[1.0.5]: https://github.com/guanguans/laravel-api-response/compare/1.0.4...1.0.5
[1.0.4]: https://github.com/guanguans/laravel-api-response/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/guanguans/laravel-api-response/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/guanguans/laravel-api-response/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/guanguans/laravel-api-response/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc3...1.0.0
[1.0.0-rc3]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc2...1.0.0-rc3
[1.0.0-rc2]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-rc1...1.0.0-rc2
[1.0.0-rc1]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta3...1.0.0-rc1
[1.0.0-beta3]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta2...1.0.0-beta3
[1.0.0-beta2]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta1...1.0.0-beta2
