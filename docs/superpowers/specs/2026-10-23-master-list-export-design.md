# Master list XLSX export optimization

Approved scope: optimize the existing synchronous XLSX download for trip batches.

Preserve the 18 columns, row order, category text, pickup codes, user visibility,
soft-deleted pickup exclusion, number formatting, and total tax footer. Replace
automatic column measurement with fixed widths. Select only the fields used by
the mapper and its accessors, including relationship keys. Fetch 1,000 parcels
per chunk and keep eager loading to avoid queries during mapping.

Retain the existing dedicated file cell cache and EXCEL_CACHE_DRIVER overrides.
The proposed batch cache was rejected during validation: a dense 1,005-row
workbook failed with `Spreadsheet objects cannot be serialized` when the buffer
spilled to disk. No queue worker or new dependency is required.

Use the actual `parcels.percent` column for Percentage (%). The original mapper
read a nonexistent `percentage` attribute and therefore exported zero instead of
the saved percentage. Selecting that nonexistent column would also fail SQL.

Validate generated workbooks across chunk boundaries, missing relationships,
batch isolation, and deleted pickups. Benchmark the old and new exports with
the same synthetic dataset; local timing does not predict cPanel performance.

Deployment: clear Laravel's config cache after uploading. Retain
EXCEL_CACHE_DRIVER=illuminate. The dedicated cell-cache directory must stay writable.

## WhatsApp Bot export extension

The user also requested the same optimization for both all-trip and single-trip
WhatsApp exports. Preserve the ten columns, message templates, pickup filters,
zero totals for empty pickups, and missing-user/office behavior. Precompute total
billing, tax, permit and parcel count in the pickup query. Pass these values to
GeneralWhatsappText through an optional billing array; its existing two-argument
callers retain their calculation path. Use 1,000-row chunks, select required
fields, and use fixed A:J widths with wrapping on the actual message column J.
Retain dedicated file caching. Regression tests must compare messages with the
existing helper, ensure mapping has no per-pickup queries, and reopen an XLSX
containing more than 1,000 pickups.
