import * as bootstrap from 'bootstrap'
import Swal from 'sweetalert2'

import '@/assets/css/all.min.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import '@/assets/css/style.css'
import '@/assets/css/theme.css'
import 'sweetalert2/src/sweetalert2.scss'

// Bootstrap 5 ships its own bundled Popper and no longer depends on jQuery.
// Expose it globally so components can grab a Modal/Collapse instance when needed.
window.bootstrap = bootstrap

window.Swal = Swal.mixin({
	customClass: {
		confirmButton: 'btn btn-success',
		cancelButton: 'btn btn-danger',
		infoButton: 'btn btn-info'
	},
	buttonsStyling: false
})

window.internet = true
