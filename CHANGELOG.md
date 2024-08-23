<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="1.0.0-beta2"></a>
## [1.0.0-beta2] - 2024-08-23
### Bug Fixes
- **CollectionMacro:** add unshift method to CollectionMacro

### Test
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

### Test
- Refactor tests and skip unimplemented tests
- **apiResponse:** Refactor API response tests to use instance method


[Unreleased]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta2...HEAD
[1.0.0-beta2]: https://github.com/guanguans/laravel-api-response/compare/1.0.0-beta1...1.0.0-beta2
