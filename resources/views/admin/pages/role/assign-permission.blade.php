@extends('admin.layout.app')

@push('css')
    <style>
        hr:not([size])
        {
            height: 0px;
        }
    </style>
@endpush


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        Add Permissions to Role:
                        <span class="fw-bolder text-primary">{{ $role->name }}</span>
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.role.assign-permission-update', $role->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        @foreach($groupedPermissions as $groupName => $permissions)
                            <div class="rounded p-3 mb-4">
                                <div class="form-check mb-2">
                                    <input
                                            type="checkbox"
                                            class="form-check-input group-checkbox"
                                            id="group_{{ Str::slug($groupName) }}"
                                            data-group="{{ Str::slug($groupName) }}"
                                    >
                                    <label class="form-check-label fw-bold" for="group_{{ Str::slug($groupName) }}">
                                        {{ $groupName }}
                                    </label>
                                </div>
                                <hr>

                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input
                                                        class="form-check-input permission-checkbox group-{{ Str::slug($groupName) }}"
                                                        name="permissions[]"
                                                        type="checkbox"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}"
                                                        @checked($role->hasPermissionTo($permission->name))
                                                >
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        @endforeach

                        <div class="mt-4 d-flex justify-content-end">
                            <button class="btn btn-lg btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // When group checkbox is toggled
            document.querySelectorAll(".group-checkbox").forEach(function (groupCheckbox) {
                groupCheckbox.addEventListener("change", function () {
                    let groupClass = 'group-' + this.dataset.group;
                    let checkboxes = document.querySelectorAll('.' + groupClass);
                    checkboxes.forEach(function (cb) {
                        cb.checked = groupCheckbox.checked;
                    });
                });
            });
        });
    </script>
@endpush