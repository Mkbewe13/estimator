# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

## [0.1.1] - 2024-01-29
### Added
- Hide edit button in Show QuotationData view if status is not "new"
- A description of the application download (content of the application prompt) has been added in the docx file, for the person who will correct the estimates.
- Self backend code review with code improvement
- New Enums directory with QuotationStatus enum class.
- Add deleting QuotationData
- Log error info instead of code

## [0.1.0] - 2024-01-24
MVP version
### Added
- Add laravel sail
- Service for connection with OpenAi Completion tool using Curl.
- Service for preparing and handling prompts for estimations generation.
- Simple authentication based on laravel breeze.
- Simplest possible UI based on laravel breeze.
- QuotationData model for storing data about the application you want to estimate.
- QuotationResult model for storing data of generated estimation.
- Required controllers (for QuotationData and Xls processing)
- Queue job "QuotationJob" for handling asynchronous LLM call to avoid timeouts.
- Export for xlsx file with quotation

