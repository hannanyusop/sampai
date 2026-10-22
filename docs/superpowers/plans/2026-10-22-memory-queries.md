# Memory-safe queries implementation plan

Goal: prevent model hydration proportional to historical parcel/customer totals while preserving existing filters and scopes.

Approved approach: replace collection-only counts with database aggregates; paginate rendered lists; stream export rows with chunked Eloquent reads; chunk spreadsheet preview reads and bound editable preview size with an explicit validation error. Never silently truncate uploads. Keep all office, status, customer-type, soft-delete, batch, and optional trip filters.

- [x] Counts: update GeneralHelper::generateTripCode and BaseService::count. Test office filtering, service clauses, scopes, limits, and clause reset.
- [x] Dashboards: add relationship counts, preserve TripBatchGeneralService query entrypoints, paginate active/closed/picked batches with distinct query parameters, retain global summary totals.
- [x] Lists: paginate unregistered parcels and both Livewire checklists. Clone the same constrained checklist query for totals, search, reset and list. Keep batch trip selection as a subquery, including its scopes.
- [x] Exports: replace FromArray with FromQuery/WithMapping in MasterListExport, BiaccExport, WhatsappBotExport; write unchanged header/data/footer rows from chunked queries, preserving optional trip filtering. Use immediate cell caching with a dedicated file cache store so workbook cells are stored on disk.
- [x] Bulk preview: read only sheet zero in chunks; reject previews above 500 rows rather than retain unlimited Livewire state. Resolve customers by phone within the existing user-type and soft-delete scopes. Search customer options in bounded pages plus selected customers; retain existing row validation and insert service.
- [x] Verification: use isolated SQLite regression tests (no production migrations), exercise count/filter equivalence, pagination and out-of-batch records, export row content and optional trip selection, import limits and customer selection. Run PHP lint and compile affected Blade templates.

Verification completed on PHP 8.2 with memory_limit=256M: 17 targeted tests, 85 assertions; syntax checks for all 19 changed/new PHP files; seven Blade templates compiled and parsed. No production database operations or notification sends were performed.
