  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  {{-- Sweet Alert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


  <script>
      // Session timeout settings
      const sessionLifetime = {{ config('session.lifetime') }}; // Lifetime in minutes
      const warningTime = 5; // Time before session expires to show the warning (in minutes)
      const sessionTimeout = (sessionLifetime - warningTime) * 60 * 1000; // Warning before session expiry in milliseconds

      let warningTimer, sessionTimer;

      // Function to show the session timeout modal
      function showSessionTimeoutModal() {
          $('#sessionTimeoutModal').modal('show');
      }

      // Function to refresh the session
      function refreshSession() {
          fetch("{{ route('session.refresh') }}", {
                  method: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  }
              })
              .then(response => {
                  if (response.ok) {
                      resetTimers(); // Reset the timers if session is refreshed
                  }
              });
      }

      // Function to reset timers
      function resetTimers() {
          clearTimeout(warningTimer);
          clearTimeout(sessionTimer);

          warningTimer = setTimeout(showSessionTimeoutModal, sessionTimeout);
          sessionTimer = setTimeout(() => {
              window.location.href = "{{ route('logout') }}"; // Auto-logout after session expiry
          }, sessionLifetime * 60 * 1000);
      }

      // Initialize the timers when the page loads
      document.addEventListener('DOMContentLoaded', () => {
          resetTimers();
      });

      // Event listener for 'Stay Logged In' button
      //   document.getElementById('stayLoggedInButton').addEventListener('click', () => {
      //       $('#sessionTimeoutModal').modal('hide');
      //       refreshSession();
      //   });

      // Event listener for 'Logout' button
      //   document.getElementById('logoutButton').addEventListener('click', () => {
      //       window.location.href = "{{ route('logout') }}";
      //   });
  </script>
