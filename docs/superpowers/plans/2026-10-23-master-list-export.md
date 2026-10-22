# Master List Export Implementation Plan

**Goal:** Reduce query payload and spreadsheet generation work for master lists.

**Architecture:** Keep the Livewire download and mapper contract. Optimize the
export query and use fixed column widths. Retain the existing dedicated file
cell cache after the proposed batch cache failed its spill-to-disk benchmark.

**Tech Stack:** Laravel 8, Laravel Excel 3.1, PhpSpreadsheet, PHPUnit 9.

**Spec:** ../specs/2026-10-23-master-list-export-design.md

## Global constraints

- Preserve the 18 columns, numbering, totals, relationship and soft-delete semantics.
- No new dependencies or queue requirements.
- Keep existing EXCEL_CACHE_DRIVER overrides.

## Task 1: Optimize and verify the export

- [x] Extend `tests/Feature/MemoryQueryTest.php` fixture with the real export fields.
  Verify 1,005 rows across two 1,000-row queries, all 18 mapped values, missing
  relationships, deleted pickup exclusion, total tax, and no queries during mapping.
- [x] Update `app/Exports/Trip/MasterListExport.php`: select mapper fields plus
  relationship keys; eager load `user:id,phone_number` without roles/permissions,
  `pickup:id,code,status`, and `dropPoint:id,name`; use chunk size 1,000. Remove
  ShouldAutoSize and assign widths to A:R, preserving M=40.
- [x] Benchmark the proposed batch cache before adoption. If spilling buffered
  cells cannot preserve workbook generation, retain the existing file cache.
  Document the outcome and cPanel deployment in README.md. Map the real `percent`
  column instead of the original nonexistent `percentage` attribute.
- [x] Run `php -d error_reporting=22527 vendor/bin/phpunit --no-configuration
  --bootstrap vendor/autoload.php tests/Feature/MemoryQueryTest.php
  tests/Feature/ParcelDataTest.php` using test environment and SQLite fixtures.
- [x] Benchmark old and new exports against identical synthetic records in fresh
  PHP processes, including peak memory. Check `git diff --check` and syntax.

Execute inline under the user's explicit implementation request. Leave changes
uncommitted for review.

## Validation results

- 18 targeted regression tests passed (256 assertions), including workbook
  readback across the 1,000-row boundary, all mapped fields, tax footer, batch
  and soft-delete filters, missing relationships, and customer code visibility.
- Local synthetic benchmark: 1,005 dense rows, fresh PHP processes, SQLite,
  dedicated file cell cache for both implementations. Original: 7.203 seconds,
  30 queries, 52 MB peak. Optimized: 5.716 seconds, 8 queries, 54 MB peak.
  Generation timing excludes fixture setup and workbook readback. Both generated
  files were reopened and verified for row numbering and total tax.
- The proposed batch cache failed on spilling a dense workbook to the file
  store, so no cache configuration or environment change ships.
- Syntax checks and `git diff --check` passed. Live cPanel timing remains unmeasured.

## Task 2: WhatsApp Bot export (user-requested scope extension)

- [x] In `app/Exports/Trip/WhatsappBotExport.php`, select pickup and related
  display fields, add SQL aggregates for billing/tax/permit/count, use 1,000-row
  chunks, and replace autosizing with fixed A:J widths and message wrapping on J.
- [x] In `app/Services/Parcel/ParcelHelperService.php`, add optional
  `?array $billing = null` to `GeneralWhatsappText`. Use supplied `total`, `tax`,
  `permit`, `total_parcel` values with lazy fallback to the original calculations.
- [x] Add regression tests comparing old and precomputed message values and
  reopening a 1,001-row WhatsApp workbook. Verify bounded query counts, empty
  pickups, missing relations, trip/batch filters, numbering and all ten columns.
- [x] Run the targeted regression suite, syntax checks, and local before/after
  benchmark; document results and deployment notes.

WhatsApp validation: 20 targeted regression tests passed (298 assertions).
The 1,001-pickup synthetic benchmark used SQLite and the dedicated file cache
in fresh PHP processes, with query logging enabled for both variants. Original:
4.314 seconds, 13,032 queries, 60 MB peak. Optimized: 3.312 seconds, 7 queries,
52 MB peak. Both workbooks were reopened and checked for numbering, pickup code,
billing amount, and identical final message text. Live cPanel timing remains
unmeasured. Syntax checks and `git diff --check` passed.
