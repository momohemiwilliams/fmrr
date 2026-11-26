<style>
    /* Modern FMDQ Regulation Table Styling */
    #{{ $tableId }} {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        margin-bottom: 1rem !important;
    }

    #{{ $tableId }} thead th,
    #{{ $tableId }} thead.thead-dark th {
        background-color: #0c2b70 !important;
        color: #ffffff !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        letter-spacing: 0.35px;
        text-transform: uppercase;
        padding: 14px 14px !important;
        border: none !important;
        border-bottom: 2px solid #b5892e !important;
        white-space: nowrap;
        vertical-align: middle !important;
    }

    #{{ $tableId }} thead th:first-child {
        text-align: left !important;
        padding-left: 18px !important;
    }

    #{{ $tableId }} tbody td {
        background-color: #ffffff !important;
        color: #1e293b !important;
        font-size: 13.5px !important;
        line-height: 1.45;
        padding: 13px 14px !important;
        border: none !important;
        border-bottom: 1px solid #eef2f6 !important;
        vertical-align: middle !important;
        transition: background-color 0.15s ease;
    }

    #{{ $tableId }} tbody tr:last-child td {
        border-bottom: none !important;
    }

    #{{ $tableId }} tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    /* Title column */
    #{{ $tableId }} tbody td:first-child {
        text-align: left !important;
        padding-left: 18px !important;
        min-width: 240px;
        font-weight: 500;
        color: #0f172a !important;
    }

    #{{ $tableId }} tbody td:first-child a {
        color: #0c2b70 !important;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.15s ease;
    }

    #{{ $tableId }} tbody td:first-child a:hover {
        color: #b5892e !important;
        text-decoration: underline;
    }

    /* Soft-tinted status & tag pills */
    #{{ $tableId }} tbody td .badge {
        border-radius: 999px !important;
        padding: 4px 10px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        letter-spacing: 0.2px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 2px !important;
        box-shadow: none !important;
        white-space: nowrap;
    }

    #{{ $tableId }} tbody td .badge-success {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }

    #{{ $tableId }} tbody td .badge-danger {
        background-color: #fef2f2 !important;
        color: #b91c1c !important;
        border: 1px solid #fecaca !important;
    }

    #{{ $tableId }} tbody td .badge-warning {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }

    #{{ $tableId }} tbody td .badge-secondary {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }

    #{{ $tableId }} tbody td .badge-primary,
    #{{ $tableId }} tbody td .badge-info {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
    }

    /* Related Documents clickable chip */
    #{{ $tableId }} tbody td span[data-target^="#relatedDocsModal-"] {
        display: inline-flex !important;
        align-items: center;
        padding: 4px 11px !important;
        border-radius: 999px !important;
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        white-space: nowrap;
        transition: all 0.15s ease;
    }

    #{{ $tableId }} tbody td span[data-target^="#relatedDocsModal-"]:hover {
        background-color: #dbeafe !important;
        border-color: #93c5fd !important;
    }

    /* Action cell & icon buttons */
    #{{ $tableId }} tbody td.tb-odr-action,
    #{{ $tableId }} tbody td:last-child {
        display: table-cell !important;
        vertical-align: middle !important;
        text-align: center !important;
        white-space: nowrap !important;
    }

    #{{ $tableId }} .tb-odr-btns {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    #{{ $tableId }} .tb-odr-btns .btn,
    #{{ $tableId }} td.tb-odr-action .btn-icon {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
        color: #0c2b70 !important;
        box-shadow: none !important;
        transition: all 0.15s ease;
    }

    #{{ $tableId }} .tb-odr-btns .btn:hover,
    #{{ $tableId }} td.tb-odr-action .btn-icon:hover {
        background-color: #0c2b70 !important;
        border-color: #0c2b70 !important;
        color: #ffffff !important;
        transform: translateY(-1px);
    }

    /* Pagination polish */
    .pagination .page-item.active .page-link {
        background-color: #0c2b70 !important;
        border-color: #0c2b70 !important;
        color: #ffffff !important;
    }

    .pagination .page-link {
        color: #0c2b70;
        border-color: #e2e8f0;
    }

    .pagination .page-link:hover {
        background-color: #f1f5f9;
        color: #0c2b70;
    }

    /* Modern Related Documents Modal */
    .related-docs-modal .modal-content {
        border: none !important;
        border-radius: 16px !important;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2) !important;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .related-docs-modal .modal-header {
        background-color: #0c2b70 !important;
        color: #ffffff !important;
        padding: 18px 24px !important;
        border-bottom: 3px solid #b5892e !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 12px;
    }

    .related-docs-modal .modal-header .modal-title {
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        line-height: 1.4;
        margin: 0 !important;
    }

    .related-docs-modal .modal-header .badge-primary {
        background-color: #b5892e !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 999px !important;
        padding: 7px 14px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.16);
        transition: background-color 0.15s ease, transform 0.15s ease;
    }

    .related-docs-modal .modal-header .badge-primary:hover {
        background-color: #9e7523 !important;
        transform: translateY(-1px);
    }

    .related-docs-modal .modal-body {
        background-color: #f8fafc !important;
        padding: 20px 24px !important;
    }

    .related-docs-modal .accordion {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .related-docs-modal .accordion-item {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        overflow: hidden;
        background-color: #ffffff !important;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .related-docs-modal .accordion-button {
        background-color: #ffffff !important;
        color: #0f172a !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        padding: 14px 18px !important;
        box-shadow: none !important;
        gap: 10px;
    }

    .related-docs-modal .accordion-button:not(.collapsed) {
        background-color: #f1f5f9 !important;
        color: #0c2b70 !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .related-docs-modal .accordion-button .badge {
        border-radius: 999px !important;
        padding: 4px 10px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        margin-right: 8px;
        white-space: nowrap;
    }

    .related-docs-modal .accordion-button .badge-success {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }

    .related-docs-modal .accordion-button .badge-danger {
        background-color: #fef2f2 !important;
        color: #b91c1c !important;
        border: 1px solid #fecaca !important;
    }

    .related-docs-modal .accordion-button .badge-warning {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }

    .related-docs-modal .accordion-button .badge-secondary {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }

    .related-docs-modal .accordion-body {
        background-color: #ffffff !important;
        padding: 18px 20px !important;
    }

    .related-docs-modal .related-doc-details .row {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        margin: 0 0 16px 0 !important;
    }

    .related-docs-modal .related-doc-details p {
        margin-bottom: 6px;
        font-size: 13.5px;
        color: #334155;
    }

    .related-docs-modal .related-doc-details p:last-child {
        margin-bottom: 0;
    }

    .related-docs-modal .related-doc-details strong {
        color: #0c2b70;
        font-weight: 600;
        margin-right: 4px;
    }

    .related-docs-modal .btn-primary {
        background-color: #0c2b70 !important;
        border-color: #0c2b70 !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        padding: 7px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: none !important;
    }

    .related-docs-modal .btn-primary:hover {
        background-color: #091f52 !important;
        border-color: #091f52 !important;
        color: #ffffff !important;
    }

    .related-docs-modal .btn-outline-primary {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #0c2b70 !important;
        border-radius: 8px !important;
        padding: 7px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .related-docs-modal .btn-outline-primary:hover {
        background-color: #f1f5f9 !important;
        border-color: #0c2b70 !important;
        color: #0c2b70 !important;
    }

    .related-docs-modal .modal-footer {
        background-color: #ffffff !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 14px 24px !important;
        display: flex !important;
        justify-content: flex-end !important;
    }

    .related-docs-modal .modal-footer .btn-secondary {
        width: auto !important;
        min-width: 96px;
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        padding: 8px 18px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
    }

    .related-docs-modal .modal-footer .btn-secondary:hover {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
</style>

