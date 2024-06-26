<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgb(35, 47, 37)
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgb(1, 25, 6)
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: 'Comfortaa', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto text-gray-700 sm:h-20">
                        <g clip-path="url(#clip0)" fill="#EF3B2D">
                            <path d="M248.032 44.676h-16.466v100.23h47.394v-14.748h-30.928V44.676zM337.091 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.431 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162-.001 2.863-.479 5.584-1.432 8.161zM463.954 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.432 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162 0 2.863-.479 5.584-1.432 8.161zM650.772 44.676h-15.606v100.23h15.606V44.676zM365.013 144.906h15.607V93.538h26.776V78.182h-42.383v66.724zM542.133 78.182l-19.616 51.096-19.616-51.096h-15.808l25.617 66.724h19.614l25.617-66.724h-15.808zM591.98 76.466c-19.112 0-34.239 15.706-34.239 35.079 0 21.416 14.641 35.079 36.239 35.079 12.088 0 19.806-4.622 29.234-14.688l-10.544-8.158c-.006.008-7.958 10.449-19.832 10.449-13.802 0-19.612-11.127-19.612-16.884h51.777c2.72-22.043-11.772-40.877-33.023-40.877zm-18.713 29.28c.12-1.284 1.917-16.884 18.589-16.884 16.671 0 18.697 15.598 18.813 16.884h-37.402zM184.068 43.892c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002-35.648-20.524a2.971 2.971 0 00-2.964 0l-35.647 20.522-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v38.979l-29.706 17.103V24.493a3 3 0 00-.103-.776c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002L40.098 1.396a2.971 2.971 0 00-2.964 0L1.487 21.919l-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v122.09c0 1.063.568 2.044 1.489 2.575l71.293 41.045c.156.089.324.143.49.202.078.028.15.074.23.095a2.98 2.98 0 001.524 0c.069-.018.132-.059.2-.083.176-.061.354-.119.519-.214l71.293-41.045a2.971 2.971 0 001.489-2.575v-38.979l34.158-19.666a2.971 2.971 0 001.489-2.575V44.666a3.075 3.075 0 00-.106-.774zM74.255 143.167l-29.648-16.779 31.136-17.926.001-.001 34.164-19.669 29.674 17.084-21.772 12.428-43.555 24.863zm68.329-76.259v33.841l-12.475-7.182-17.231-9.92V49.806l12.475 7.182 17.231 9.92zm2.97-39.335l29.693 17.095-29.693 17.095-29.693-17.095 29.693-17.095zM54.06 114.089l-12.475 7.182V46.733l17.231-9.92 12.475-7.182v74.537l-17.231 9.921zM38.614 7.398l29.693 17.095-29.693 17.095L8.921 24.493 38.614 7.398zM5.938 29.632l12.475 7.182 17.231 9.92v79.676l.001.005-.001.006c0 .114.032.221.045.333.017.146.021.294.059.434l.002.007c.032.117.094.222.14.334.051.124.088.255.156.371a.036.036 0 00.004.009c.061.105.149.191.222.288.081.105.149.22.244.314l.008.01c.084.083.19.142.284.215.106.083.202.178.32.247l.013.005.011.008 34.139 19.321v34.175L5.939 144.867V29.632h-.001zm136.646 115.235l-65.352 37.625V148.31l48.399-27.628 16.953-9.677v33.862zm35.646-61.22l-29.706 17.102V66.908l17.231-9.92 12.475-7.182v33.841z"/>
                        </g>
                    </svg>
                </div> --}}
            <h1 class="text-gray-200">Moboeats Privacy Policy</h1>
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h3 class="">Last updated: {{ Carbon\Carbon::now()->subMonths(2)->format('M, d Y') }}</h3>
                    <p>
                        This Privacy Policy describes procedures on the collection, use and disclosure of the student
                        information when one uses the application and tells you about your privacy rights and how the
                        law protects You.
                        We use Your Personal data to provide and improve our Service. By using our app, you agree to
                        the collection and use of information in accordance with this Privacy Policy. This Privacy
                        Policy
                        has been created by Deveint Limited.
                    </p>
                </div>
                <div class="text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h2>Interpretation and Definitions</h2>
                    <h3>Interpretation</h3>
                    <p>
                        The words of which the initial letter is capitalized have meanings defined under the following
                        conditions. The following definitions shall have the same meaning regardless of whether they
                        appear in singular or in plural.
                    </p>
                    <h3>Definitions</h3>
                    <p>For the purposes of this Privacy Policy:</p>
                    <ul>
                        <li>
                            <strong>Account</strong> means a unique account created for You to access our Service or
                            parts of our
                            Service.
                        </li>
                        <li>
                            <strong>Affiliate</strong> means an entity that controls, is controlled by or is under
                            common control with
                            a party, where "control" means ownership of 50% or more of the shares, equity interest
                            or other securities entitled to vote for election of directors or other managing authority.
                        </li>
                        <li>
                            <strong>Application</strong> means the software program provided by the Company downloaded
                            by You
                            on any electronic device, named Moboeats.
                        </li>
                        <li>
                            <strong>Company</strong> (referred to as either "the Company", "We", "Us" or "Our" in this
                            Agreement) refers to Moboeats.
                        </li>
                        <li>
                            <strong>Country</strong> refers to the national.
                        </li>
                        <li>
                            <strong>Device</strong> means any device that can access the Service such as a computer, a
                            cellphone or a digital tablet.
                        </li>
                        <li>
                            <strong>Personal Data</strong> is any information that relates to an identified or
                            identifiable individual.
                        </li>
                        <li>
                            <strong>Service</strong> refers to the application
                        </li>
                        <li>
                            <strong>Service Provider</strong> means any natural or legal person who processes the data
                            on behalf of the Company. It refers to third-party companies or individuals employed by the
                            Company to facilitate the Service, to provide the Service on behalf of the Company, to
                            perform services related to the Service or to assist the Company in analyzing how the
                            Service is used.
                        </li>
                        <li>
                            <strong>Usage Data</strong> refers to data collected automatically, either generated by the
                            use of the Service or from the Service infrastructure itself (for example, the duration of a
                            page visit).
                        </li>
                        <li>
                            <strong>You</strong> means the individual accessing or using the Service, or the company, or
                            other legal entity on behalf of which such individual is accessing or using the Service, as
                            applicable.
                        </li>
                    </ul>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h2>Collecting and Using Your Personal Data</h2>
                    <h3>Types of Data Collected</h3>

                    <h2>Personal Data</h2>
                    <p>
                        While using Our Service, We may ask You to provide Us with certain personally identifiable
                        information that can be used to contact or identify You. Student identifiable information may
                        include, but is not limited to:
                    </p>
                    <ul>
                        <li>Email Address</li>
                        <li>First name and last name</li>
                        <li>Phone Number</li>
                        <li>Location</li>
                        <li>Usage Data</li>
                    </ul>
                    <h2>Usage Data</h2>
                    <p>
                        Usage Data is collected automatically when using the Service.
                    </p>
                    <p>
                        Usage Data may include information such as Your Device's Internet Protocol address (e.g. IP
                        address), browser type, browser version, the features that You have used,, the time and date of
                        Your app visit, the time spent on lessons, unique device identifiers and other diagnostic data.
                    </p>
                    <p>
                        When You access our application, We may collect certain information automatically, including,
                        but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP
                        address of Your mobile device, Your mobile operating system, the type of mobile Internet browser
                        You use, unique device identifiers and other diagnostic data
                    </p>
                    <p>
                        We may also collect information that Your browser sends whenever You visit our Service or when
                        You access the Service by or through a mobile device.
                    </p>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h2>Information Collected while Using the Application</h2>
                    <p>While using Our Application, in order to provide features of Our Application, We may collect,
                        with
                        Your prior permission:
                    </p>
                    <ul>
                        <li>Pictures and other information from your Device's camera and photo library</li>
                    </ul>
                    <p>
                        We use this information to provide features of Our Service, to improve and customize Our
                        Service. The information may be uploaded to the Company's servers and/or a Service
                        Provider's server or it may be simply stored on Your device.
                    </p>
                    <p>
                        You can enable or disable access to this information at any time, through Your Device settings.
                    </p>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h2>Use of Your Personal Data</h2>
                    <p>The Company may use Personal Data for the following purposes:</p>
                    <ul>
                        <li>
                            <strong>To provide and maintain our Service</strong> including to monitor the usage of our
                            Service.
                        </li>
                        <li>
                            <strong>To manage personal account</strong> to manage Your registration as a user of the
                            Service. The
                            Personal Data You provide can give You access to different functionalities of the Service
                            that are available to You as a registered user
                        </li>
                        <li>
                            <strong>For the performance of a contract</strong> the development, compliance and
                            undertaking of
                            the purchase contract for the products, items or services You have purchased or of any
                            other contract with Us through the Service.
                        </li>
                        <li>
                            <strong>To Contact You</strong> To contact You by email, telephone calls, SMS, or other
                            equivalent forms
                            of electronic communication, such as a mobile application's push notifications regarding
                            updates or informative communications related to the functionalities, products or
                            contracted services, including the security updates, when necessary or reasonable for
                            their implementation
                        </li>
                        <li>
                            <strong>To Provide You </strong> with news, special offers and general information about
                            other goods,
                            services and events which we offer that are similar to those that you have already
                            purchased or enquired about unless You have opted not to receive such information.
                        </li>
                        <li>
                            <strong>To manage your requests</strong> To attend and manage Your requests to Us.
                        </li>
                        <li>
                            <strong>For business transfers</strong> We may use Your information to evaluate or conduct a
                            merger,
                            divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some
                            or
                            all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or
                            similar proceeding, in which Personal Data held by Us about our Service users is among
                            the assets transferred.
                        </li>
                        <li>
                            <strong>For other purposes:</strong> We may use Your information for other purposes, such as
                            data
                            analysis, identifying usage trends, determining the effectiveness of our promotional
                            campaigns and to evaluate and improve our Service, products, services, marketing and
                            your experience
                        </li>
                    </ul>
                    <p>We may share Your personal information in the following situations:</p>
                    <ul>
                        <li>
                            <strong>With Service Providers:</strong> We may share Your personal information with Service
                            Providers
                            to monitor and analyze the use of our Service, to contact You
                        </li>
                        <li>
                            <strong>For business transfers:</strong> We may share or transfer Your personal information
                            in
                            connection with, or during negotiations of, any merger, sale of Company assets,
                            financing, or acquisition of all or a portion of Our business to another company.
                        </li>
                        <li>
                            <strong>With Affiliates:</strong> We may share Your information with Our affiliates, in
                            which case we will
                            require those affiliates to honor this Privacy Policy. Affiliates include Our parent company
                            and any other subsidiaries, joint venture partners or other companies that We control or
                            that are under common control with Us
                        </li>
                        <li>
                            <strong>With business partners:</strong> We may share Your information with Our business
                            partners to
                            offer You certain products, services or promotions.
                        </li>
                        <li>
                            <strong>With Other Users:</strong> when You share personal information or otherwise interact
                            in the
                            public areas with other users, such information may be viewed by all users and may be
                            publicly distributed outside
                        </li>
                        <li>
                            <strong>With Your Consent:</strong> We may disclose Your personal information for any other
                            purpose
                            with Your consent
                        </li>
                    </ul>

                    <h3>Transfer of Personal Data</h3>
                    <p>
                        Your information, including Personal Data, is processed at the Company's operating offices and
                        in any other places where the parties involved in the processing are located. It means that this
                        information may be transferred to — and maintained on — computers located outside of Your
                        state, province, country or other governmental jurisdiction where the data protection laws may
                        differ than those from Your jurisdiction
                    </p>
                    <p>
                        Your consent to this Privacy Policy followed by Your submission of such information represents
                        Your agreement to that transfer.
                    </p>
                    <p>
                        The Company will take all steps reasonably necessary to ensure that Your data is treated
                        securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will
                        take place to an organization or a country unless there are adequate controls in place including
                        the security of Your data and other personal information.
                    </p>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <h2>Disclosure of Your Personal Data</h2>
                    <h3>Business Transactions</h3>
                    <p>
                        If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be
                        transferred. We will provide notice before Your Personal Data is transferred and becomes
                        subject to a different Privacy Policy.
                    </p>
                    <h3>Law Enforcement</h3>
                    <p>
                        Under certain circumstances, the Company may be required to disclose Your Personal Data if
                        required to do so by law or in response to valid requests by public authorities (e.g. a court or
                        a
                        government agency).
                    </p>
                    <h3>Other Legal Requirements</h3>
                    <p>
                        The Company may disclose Your Personal Data in the good faith belief that such action is
                        necessary to:
                    </p>
                    <ul>
                        <li>
                            Comply with legal obligation
                        </li>
                        <li>
                            Protect and defend the rights or property of the Company
                        </li>
                        <li>
                            Prevent or investigate possible wrongdoing in connection with the Service
                        </li>
                        <li>
                            Protect the personal safety of Users of the Service or the public
                        </li>
                        <li>
                            Protect against legal liability
                        </li>
                    </ul>
                    <h3>Security of Your Personal Data</h3>
                    <p>
                        The security of Your Personal Data is important to Us, but remember that no method of
                        transmission over the Internet, or method of electronic storage is 100% secure. While We strive
                        to
                        use commercially acceptable means to protect Your Personal Data, We cannot guarantee its
                        absolute security.
                    </p>
                    <h3>Links to Other Websites</h3>
                    <p>
                        Our Service may contain links to other websites that are not operated by us. If You click on a
                        third party link, You will be directed to that third party's site. We strongly advise You to
                        review the
                        Privacy Policy of every site You visit.
                    </p>
                    <p>
                        We have no control over and assume no responsibility for the content, privacy policies or
                        practices of any third party sites or services.
                    </p>
                    <h3>Change to This Privacy Policy</h3>
                    <p>
                        We may update Our Privacy Policy from time to time. We will notify You of any changes by
                        posting the new Privacy Policy on this page.
                    </p>
                    <p>
                        We will let You know via email and/or a prominent notice on Our Service, prior to the change
                        becoming effective and update the "Last updated" date at the top of this Privacy Policy.
                    </p>
                    <p>
                        You are advised to review this Privacy Policy periodically for any changes. Changes to this
                        Privacy Policy are effective when they are posted on this page.
                    </p>
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm p-6">
                    <p>
                        If you have any questions about this Privacy Policy, You can contact us:
                    </p>
                    <ul>
                        <li>By email: <strong>info@moboeats.com</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
