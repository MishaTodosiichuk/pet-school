<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </ul>
    </nav>

    @include('admin.includes.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @yield('header')
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
               @yield('content')
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; {{now()->year}} <a href="#">Васловівський ЗЗСО</a>.</strong>
        Всі права захищені.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 0.1
        </div>
    </footer>
</div>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('dist/js/adminlte.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            lang: 'uk-UA',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    $(document).ready(function () {
        bsCustomFileInput.init();

        let fileStorage = {};

        $('.preview-trigger').on('change', function(e) {
            let container = $($(this).data('preview-container'));
            let files = e.target.files;

            $.each(files, function(i, file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    let template = `
                <div class="col-md-2 col-sm-4 mb-2 new-image-preview">
                    <div class="position-relative">
                        <img src="${event.target.result}" class="img-thumbnail" style="width: 100%; height: 120px; object-fit: cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="this.parentElement.parentElement.remove()">
                            &times;
                        </button>
                    </div>
                </div>`;
                    container.append(template);
                };
                reader.readAsDataURL(file);
            });
        });

        function syncInputAndPreview(input, containerSelector) {
            const container = $(containerSelector);
            const files = fileStorage[containerSelector];
            const dt = new DataTransfer();

            const isMain = containerSelector === '#preview-image';
            const colClass = isMain ? 'col-12' : 'col-sm-4 col-md-3';
            const imgHeight = isMain ? '180px' : '120px';

            container.empty();

            files.forEach((file, index) => {
                dt.items.add(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const html = `
                    <div class="${colClass} mb-3 preview-item" data-index="${index}" data-container="${containerSelector}">
                        <div class="position-relative shadow-sm border rounded p-1" style="background: #fff;">
                            <img src="${e.target.result}"
                                 class="img-thumbnail border-0"
                                 style="height: ${imgHeight}; width: 100%; object-fit: cover; display: block;">
                            <span class="badge badge-danger position-absolute remove-file"
                                  style="top: -10px; right: -10px; cursor: pointer; z-index: 10; padding: 5px 8px; border-radius: 50%;">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
                    </div>
                `;
                    container.append(html);
                }
                reader.readAsDataURL(file);
            });

            input.files = dt.files;

            const label = $(input).next('.custom-file-label');
            label.html(files.length > 0 ? files.length + " files selected" : "Browse");
        }

        $(document).on('click', '.remove-file', function() {
            const item = $(this).closest('.preview-item');
            const indexToRemove = item.data('index');
            const containerSelector = item.data('container');
            const input = $(`.preview-trigger[data-preview-container="${containerSelector}"]`)[0];

            fileStorage[containerSelector].splice(indexToRemove, 1);

            syncInputAndPreview(input, containerSelector);
        });
    });
</script>

@stack('scripts')

</body>
</html>
