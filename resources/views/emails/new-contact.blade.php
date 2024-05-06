<h1>
    Nuova Richiesta-RocketDev
</h1>

<p>
    <ul>
        <li>
            Da: {{ $lead->name }}
        </li>

        <li>
            Email da: {{ $lead->address }}
        </li>

        <li>
            Messaggio: <br>
             {{ $lead->message }}
        </li>
    </ul>
</p>