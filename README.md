# ClockProviderBundle

A Symfony bundle that provides flexible clock services with MockClock support.
It's especially useful when working with timestampable entities where you need to manipulate the current datetime for testing.


## Configuration

Add the bundle to your `config/bundles.php`:

```php
return [
    // ...
    IWF\ClockProviderBundle\ClockProviderBundle::class => ['all' => true],
];
```

### Default Configuration

```yaml
# config/packages/clock_provider.yaml
clock_provider:
    session_key: 'app_date'                  # Session key for storing the date
    query_param: '_date'                     # Query param for setting date in URL
    env_var_name: 'ENABLE_TIME_WARP'         # Environment variable to check
```

### Enable Time Warp

To enable the time warp functionality, set the `ENABLE_TIME_WARP` environment variable to `true` or `1`:

```
# .env.local or .env
ENABLE_TIME_WARP=true
```


## Usage

### When Time Warp is Enabled

The bundle configures a `MockClock` service when `ENABLE_TIME_WARP` is set, and integrates with Gedmo Timestampable if available.

### ClockProvider Functions

Der `ClockProvider` bietet folgende Funktionen:

#### `modify(string $dateString): bool`
Setzt ein neues Datum in der Session. Das Datum muss im Format `YYYY-MM-DD` vorliegen.
Gibt `true` zurück, wenn das Datum erfolgreich gesetzt wurde, ansonsten `false`.

#### `modifyOnRequestEvent(): bool`
Ändert das Datum basierend auf dem Session-Wert oder Query-Parameter bei Anfragen.
Gibt `true` zurück, wenn das Datum erfolgreich geändert wurde, ansonsten `false`.

#### `reset(): bool`
Entfernt das gesetzte Datum aus der Session und setzt die Zeit zurück auf die aktuelle Zeit.
Gibt `true` zurück, wenn das Datum zurückgesetzt wurde, ansonsten `false`.

#### `canModifyTime(): bool`
Prüft, ob die Zeit angepasst werden kann (wenn `MockClock` verwendet wird).
Gibt `true` zurück, wenn die Zeit angepasst werden kann, ansonsten `false`.

#### `getSessionDate(): ?string`
Holt das aktuelle Datum aus der Session, falls vorhanden.
Gibt das Datum als String im Format `YYYY-MM-DD` zurück oder `null`, wenn kein Datum gesetzt ist.

#### `now(): DateTimeImmutable`
Gibt die aktuelle Zeit zurück, abhängig von der konfigurierten Clock.

#### `sleep(float|int $seconds): void`
Wartet die angegebene Anzahl von Sekunden.

#### `withTimeZone(DateTimeZone|string $timezone): static`
Gibt eine neue Clock-Instanz mit der angegebenen Zeitzone zurück.

## License

This bundle is under the MIT license.


## License

This bundle is under the MIT license.