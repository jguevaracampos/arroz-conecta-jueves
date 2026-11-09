<div style="font-family: Arial, sans-serif; max-width: 520px; margin: auto; border: 1px solid #e7e5e4; border-radius: 12px; overflow: hidden;">
    <div style="background: #166534; color: #ffffff; padding: 20px 28px;">
        <h2 style="margin: 0;">ArrozConecta</h2>
        <small>Blindaje de tu cuenta</small>
    </div>

    <div style="padding: 28px;">
        <p>Hola, <strong>{{ $user->name }}</strong>:</p>
        <p>Estos son tus <strong>6 códigos de recuperación</strong>. Cada uno sirve una sola vez.</p>

        <div style="background: #f0fdf4; border: 2px dashed #86efac; border-radius: 8px; padding: 16px; font-family: 'Courier New', monospace; font-size: 16px; line-height: 2;">
            @foreach ($codes as $codigo)
                {{ $loop->iteration }}. <strong>{{ $codigo }}</strong><br>
            @endforeach
        </div>

        <p style="color: #92400e; font-size: 13px;">
            ⚠️ Guárdalos en un lugar seguro y no los compartas. Si generas códigos nuevos, estos dejan de servir.
        </p>
    </div>
</div>