<style>
    @charset "UTF-8";

    .bootstrap-tagsinput {
        margin: 0;
        width: 100%;
        padding: 0.5rem 0.75rem 0;
        font-size: 1rem;
        line-height: 1.25;
        transition: border-color 0.15s ease-in-out;
    }

    .bootstrap-tagsinput.has-focus {
        background-color: #681320;
        border-color: #5cb3fd;
    }

    .bootstrap-tagsinput .label-info {
        display: inline-block;
        background-color: #681320;
        padding: 0 0.4em 0.15em;
        border-radius: 0.25rem;
        margin-bottom: 0.4em;
    }

    .bootstrap-tagsinput input {
        margin-bottom: 0.5em;
    }

    .bootstrap-tagsinput .tag [data-role=remove]:after {
        content: "×";
        padding: 1px 2px;
    }

    .addalert {
        border: 1px solid red !important;
    }

    .color-show {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 3px;
        border: 1px solid #000000;
        margin-right: 5px;
    }

    .image-content {
        display: flex;
        width: 150px;
        height: 100px;
        border: 1px solid #bdc6d2;
        border-radius: 10px;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background: #e1e5ec;
        position: relative;
    }

    .image-content img {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .image-content span {
        position: absolute;
        z-index: 99999;
        right: -10px;
        top: -10px;
        border-radius: 50%;
        background: red;
        color: #fff;
        width: 25px;
        height: 25px;
        padding: 0px 1px 0px 5px;
        cursor: pointer;
    }

    .image-content span i {
        font-size: 15px;
    }

    .image-content label {
        width: 100% !important;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-content label i {
        font-weight: 1000;
        font-size: 20px;
    }

    .bootstrap-tagsinput {
        border: 1px solid #b8b3b3;
        border-radius: 5px;
    }

    .bootstrap-tagsinput input {
        border: none;
        outline: none;
    }

    .bootstrap-tagsinput .label-info {
        color: #fff
    }

    ul.nav.nav-tabs.nav-fill {
        display: flex;
        flex-wrap: nowrap;
        flex-wrap: nowrap;
    }

    button.nav-link {
        padding: 10px 3px !important;
    }

    .sm-del-btn {
        position: absolute;
        right: -6px;
        top: 23px;
        background-color: red;
        color: #fff;
        padding: 4px 6px;
        font-size: 8px !important;
        border-radius: 4px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        cursor: pointer;
        z-index: 1;
    }

    .alert-success {
        background-color: #e8fadf;
        border-color: #d4f5c3;
        color: #71dd37;
        padding: 8px 22px;
    }

    /* styles for the custom dropdown */
    .custom-dropdown {
        position: relative;
        display: inline-block;
        width: 150px;
        line-height: inherit;
        text-transform: capitalize;
    }

    .dropdown-selected {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
        /*border: 1px solid #ccc;*/
        cursor: pointer;
        font-size: 16px;
    }

    .dropdown-selected span {
        display: flex;
        align-items: center;
    }

    .dropdown-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        border: 1px solid #ccc;
        border-top: none;
        background-color: #fff;
        z-index: 10;
        max-height: 280px;
        overflow: auto;
    }

    .dropdown-option {
        padding: 5px;
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 13px;
        text-transform: none;
    }

    .dropdown-option:hover {
        background-color: #f0f0f0;
    }

    .color-show {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 3px;
        border: 1px solid #000000;
        margin-right: 5px;
    }

    .dropdown-options::-webkit-scrollbar {
        width: 0;
        height: 0;
    }

    /* Hide scrollbar for Firefox */
    .dropdown-options {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
    }

    .dropdown-options.visible {
        display: block !important;
    }
</style>