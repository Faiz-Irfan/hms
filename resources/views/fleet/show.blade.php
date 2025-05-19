@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" role="switch"
                            data-id="{{ $fleet->id }}" {{ $fleet->status ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $fleet->status ? 'Active' : 'Inactive' }}
                        </label>
                    </div>
                    {{-- <div class="row h-100 justify-content-center align-items-center"> --}}
                    {{-- <div class="col-10 col-md-8 col-lg-6"> --}}
                    <h5 class="card-title">View Fleet</h5>
                    <div class="col-12">
                        <label for="name">Brand</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $fleet->brand }}"
                            required readonly>
                    </div>
                    <div class="col-12">
                        <label for="email">Model</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $fleet->model }}"
                            required readonly>
                    </div>
                    <div class="col-12">
                        <label for="email">Year</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $fleet->year }}"
                            required readonly>
                    </div>
                    <div class="col-12">
                        <label for="email">License Plate</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $fleet->license_plate }}" required readonly>
                    </div>
                    <div class="col-12">
                        <label for="email">Color</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $fleet->color }}"
                            required readonly>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('fleet.edit', $fleet->id) }}" class="btn btn-primary">Update User</a>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        console.log('hehe');
        document.querySelectorAll('.toggle-status').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const fleetId = this.dataset.id;

                fetch(`/fleet/${fleetId}/toggle-status`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.nextElementSibling.innerText = data.status ? 'Active' : 'Inactive';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection
