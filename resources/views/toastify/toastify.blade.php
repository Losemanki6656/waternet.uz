@if ($message = Session::get('success'))
    <script>
        Toastify({
            text: "{{ $message }}",
            className: "danger",
            gravity: "top",
            duration: 5000,
            position: "center",
            style: {
                background: "linear-gradient(to right, #E8E80B, #FCCC05)",
                color: "#000000"
            }
        }).showToast();
    </script>
@elseif ($message = Session::get('error'))
    <script>
        Toastify({
            text: "{{ $message }}",
            className: "danger",
            gravity: "top",
            duration: 5000,
            position: "center",
            style: {
                background: "linear-gradient(to right, #E8E80B, #FCCC05)",
                color: "#000000"
            }
        }).showToast();
    </script>
@elseif ($message = Session::get('warning'))
    <script>
        Toastify({
            text: "{{ $message }}",
            className: "danger",
            gravity: "top",
            duration: 5000,
            position: "center",
            style: {
                background: "linear-gradient(to right, #E8E80B, #FCCC05)",
                color: "#000000"
            }
        }).showToast();
    </script>
@elseif ($message = Session::get('info'))
    <script>
        Toastify({
            text: "{{ $message }}",
            className: "danger",
            gravity: "top",
            duration: 5000,
            position: "center",
            style: {
                background: "linear-gradient(to right, #E8E80B, #FCCC05)",
                color: "#000000"
            }
        }).showToast();
    </script>
@elseif ($errors->any())
    <script>
        Toastify({
            text: "{{ $message }}",
            className: "danger",
            gravity: "top",
            duration: 5000,
            position: "center",
            style: {
                background: "linear-gradient(to right, #E8E80B, #FCCC05)",
                color: "#000000"
            }
        }).showToast();
    </script>
@endif
