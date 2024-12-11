<x-mail::message>
# Nuevo Empleado Creado

Hola,

Un nuevo empleado ha sido creado exitosamente en el sistema. Aquí están los detalles del empleado:

- **Nombre:** {{ $employee->name }}
- **Correo Electrónico:** {{ $employee->email }}
- **Teléfono:** {{ $employee->phone }}
- **Departamento:** {{ $employee->department->name }}

<x-mail::button :url="''">
Ver Detalles
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
