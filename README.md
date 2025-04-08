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

#### `modify(string $dateString): bool`
Sets a new date in the session. The date must be in the format `YYYY-MM-DD`.

#### `modifyOnRequestEvent(): bool`
Changes the date based on the session value or query parameter for requests.

#### `reset(): bool`
Removes the set date from the session and sets the time back to the current time.

#### `canModifyTime(): bool`
Checks whether the time can be adjusted (if 'MockClock' is used).

#### `getSessionDate(): ?string`
Retrieves the current date from the session, if available.
Returns the date as a string in the format `YYYY-MM-DD` or `null` if no date is set.

#### `now(): DateTimeImmutable`
Returns the current time, depending on the configured clock.

## License

This bundle is under the MIT license.


## License

This bundle is under the MIT license.