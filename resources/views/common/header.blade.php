<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="random-key" content="{{ generateRandomCode(32) }}">
<!-- site metas -->
<title>@yield('page_title') {{env('APP_NAME')}} </title>
<meta name="keywords" content="Propose Me,Anniversary Proposal,Marriage proposal">
<meta name="description" content="Its A E-ORG Or Internet Company That makes your proposal memorable to your loved once.">
<meta name="author" content="Mr. SUDIP MAITY">

<!-- All CSS -->
<link href="/assets/font-awesome/font-awesome.css" rel="stylesheet">
<link href="/assets/line-awesome/line-awesome.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/datatables/datatables.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">