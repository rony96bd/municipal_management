<style>
.detail-wrapper {
    max-width: 1040px;
    margin: 0 auto 40px auto;
}

.detail-wrapper svg {
    flex-shrink: 0;
}

.detail-top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
}

.detail-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 6px;
    background-color: var(--background-gray, #f2f2f2);
    color: var(--primary-color, #000325);
    font-size: 15px;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid rgba(0, 3, 37, 0.12);
    transition: all 0.2s ease-in-out;
}

.detail-back-btn:hover {
    background-color: var(--primary-color, #000325);
    color: var(--white-color, #ffffff);
    border-color: var(--primary-color, #000325);
}

.detail-back-btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
}

.detail-breadcrumb-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: var(--secondary-color, #3361d9);
    background-color: rgba(51, 97, 217, 0.08);
    border: 1px solid rgba(51, 97, 217, 0.2);
    padding: 6px 14px;
    border-radius: 999px;
    font-weight: 500;
}

.detail-card {
    background: var(--white-color, #ffffff);
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 3, 37, 0.08);
    border: 1px solid rgba(0, 3, 37, 0.08);
    overflow: hidden;
}

.detail-card-header {
    background: linear-gradient(135deg, var(--primary-color, #000325) 0%, #151b4a 100%);
    color: var(--white-color, #ffffff);
    padding: 26px 32px;
    border-bottom: 3px solid var(--secondary-color, #3361d9);
}

.detail-header-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.15);
    color: var(--white-color, #ffffff);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 12px;
    backdrop-filter: blur(4px);
}

.detail-header-tag svg {
    width: 16px;
    height: 16px;
    stroke: var(--white-color, #ffffff);
}

.detail-card-title {
    color: var(--white-color, #ffffff);
    font-size: 24px;
    line-height: 1.45;
    margin: 0 0 12px 0;
    font-weight: 700;
}

.detail-meta-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
}

.detail-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.detail-meta-item svg {
    width: 16px;
    height: 16px;
    stroke: rgba(255, 255, 255, 0.85);
}

.detail-card-body {
    padding: 28px 32px 34px 32px;
}

/* Page content typography & container */
.detail-content-box {
    background-color: transparent;
    border: none;
    padding: 0;
    margin-bottom: 24px;
    color: var(--paragraph-color, #222222);
    font-size: 16px;
    line-height: 1.85;
    word-wrap: break-word;
}

/* Neutralize nested Bootstrap grids causing horizontal shifts */
.detail-content-box .container,
.detail-content-box .row,
.detail-content-box [class*="col-"] {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    box-sizing: border-box !important;
    float: none !important;
}

.detail-content-box p {
    margin: 0 0 14px 0;
}

.detail-content-box h1,
.detail-content-box h2,
.detail-content-box h3,
.detail-content-box h4 {
    color: var(--primary-color, #000325);
    margin: 20px 0 12px 0;
    line-height: 1.4;
    font-weight: 600;
}

.detail-content-box ul,
.detail-content-box ol {
    padding-left: 24px;
    margin: 12px 0;
}

.detail-content-box hr {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 20px 0;
}

/* Remove excessive empty spacing elements causing giant white gaps */
.detail-content-box p:empty,
.detail-content-box div:empty,
.detail-content-box h1:empty,
.detail-content-box h2:empty,
.detail-content-box h3:empty,
.detail-content-box h4:empty {
    display: none !important;
}

.detail-content-box .border:empty,
.detail-content-box .table-responsive:empty {
    display: none !important;
}

/* Responsive Table Wrapper */
.table-responsive-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 20px 0;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: var(--white-color, #ffffff);
    box-shadow: 0 2px 8px rgba(0, 3, 37, 0.04);
}

.table-scroll-hint {
    display: none;
    font-size: 13px;
    font-weight: 600;
    color: var(--secondary-color, #3361d9);
    padding: 8px 14px;
    background: rgba(51, 97, 217, 0.08);
    border-bottom: 1px solid #cbd5e1;
    text-align: center;
}

.detail-content-box table {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    border-collapse: collapse !important;
    margin: 0 !important;
    background-color: var(--white-color, #ffffff);
}

.detail-content-box table tr {
    height: auto !important;
}

.detail-content-box table th,
.detail-content-box table td {
    padding: 10px 14px !important;
    font-size: 15px;
    line-height: 1.5;
    border: 1px solid #cbd5e1 !important;
    height: auto !important;
}

.detail-content-box table thead th,
.detail-content-box table th {
    background-color: var(--primary-color, #000325);
    color: #ffffff !important;
    font-weight: 600;
}

.detail-content-box thead h1,
.detail-content-box thead h2,
.detail-content-box thead h3,
.detail-content-box thead h4,
.detail-content-box thead h5,
.detail-content-box thead h6,
.detail-content-box tr:first-child th h4 {
    color: #ffffff !important;
    margin: 0 !important;
}

/* Document & Scanned Pages Images */
.detail-content-box img {
    max-width: 100% !important;
    height: auto !important;
    display: block;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 3, 37, 0.12);
    border: 1px solid #e2e8f0;
    cursor: zoom-in;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-sizing: border-box !important;
}

.detail-content-box img:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 3, 37, 0.16);
}

.detail-content-box a {
    color: var(--secondary-color, #3361d9);
    text-decoration: underline;
}

/* Attached file section */
.detail-attachment-section {
    border: 1px solid rgba(0, 3, 37, 0.12);
    border-radius: 8px;
    overflow: hidden;
    background-color: #fafbfc;
    margin-top: 20px;
}

.detail-attachment-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 14px 20px;
    background-color: var(--background-gray, #f2f2f2);
    border-bottom: 1px solid rgba(0, 3, 37, 0.1);
}

.detail-attachment-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 600;
    color: var(--primary-color, #000325);
}

.detail-attachment-label svg {
    width: 20px;
    height: 20px;
    stroke: var(--secondary-color, #3361d9);
}

.detail-attachment-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.detail-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 15px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.detail-btn svg {
    width: 16px;
    height: 16px;
}

.detail-btn-primary {
    background-color: var(--primary-color, #000325);
    color: var(--white-color, #ffffff);
    border: 1px solid var(--primary-color, #000325);
}

.detail-btn-primary:hover {
    background-color: #151b4a;
    border-color: #151b4a;
    color: var(--white-color, #ffffff);
}

.detail-btn-primary svg {
    stroke: var(--white-color, #ffffff);
}

.detail-btn-outline {
    background-color: transparent;
    color: var(--primary-color, #000325);
    border: 1px solid rgba(0, 3, 37, 0.2);
}

.detail-btn-outline:hover {
    background-color: rgba(0, 3, 37, 0.05);
    color: var(--primary-color, #000325);
    border-color: var(--primary-color, #000325);
}

.detail-btn-outline svg {
    stroke: var(--primary-color, #000325);
}

.detail-image-viewer {
    padding: 24px;
    text-align: center;
    background-color: #f7f9fa;
}

.detail-image-viewer img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 6px;
    box-shadow: 0 4px 15px rgba(0, 3, 37, 0.1);
    cursor: zoom-in;
    transition: transform 0.2s ease;
}

.detail-image-viewer img:hover {
    transform: scale(1.01);
}

.detail-pdf-viewer {
    width: 100%;
    height: 720px;
    border: none;
    display: block;
}

.detail-file-fallback {
    padding: 36px 20px;
    text-align: center;
    background-color: #f7f9fa;
}

.detail-file-fallback p {
    font-size: 15px;
    color: #64748b;
    margin-bottom: 16px;
}

/* Lightbox Modal */
.detail-lightbox-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 3, 37, 0.88);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.detail-lightbox-overlay.active {
    display: flex;
}

.detail-lightbox-overlay img {
    max-width: 94%;
    max-height: 92vh;
    border-radius: 6px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
}

.detail-lightbox-close {
    position: fixed;
    top: 18px;
    right: 24px;
    color: #ffffff;
    font-size: 34px;
    line-height: 1;
    cursor: pointer;
    user-select: none;
    transition: transform 0.2s ease;
}

.detail-lightbox-close:hover {
    transform: scale(1.15);
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .detail-card-header {
        padding: 20px 18px;
    }

    .detail-card-body {
        padding: 20px 16px 24px 16px;
    }

    .detail-content-box {
        font-size: 15px;
        line-height: 1.75;
    }

    .table-scroll-hint {
        display: block;
    }

    .detail-content-box table {
        min-width: 560px;
    }

    .detail-attachment-toolbar {
        padding: 12px 14px;
    }

    .detail-attachment-actions {
        width: 100%;
    }

    .detail-btn {
        flex: 1 1 auto;
        justify-content: center;
    }

    .detail-pdf-viewer {
        height: 520px;
    }
}
</style>
