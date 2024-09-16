# YOURLS API Action List Extended

**Plugin Name**: YOURLS API Action List Extended  
**Version**: 1.0.0  
**Author**: Hardeep Asrani  
**Author URI**: [https://themeisle.com](https://themeisle.com)  
**Plugin URI**: [https://github.com/Codeinwp/yourls-api-list-extended](https://github.com/Codeinwp/yourls-api-list-extended)  
**Description**: YOURLS API List action with sorting, pagination, total count, and field selection.

## Description

This plugin extends the YOURLS API by adding a `list` action with advanced capabilities. It allows users to retrieve a list of shortened URLs with options for:

- Sorting by keyword, URL, title, timestamp, IP address, or clicks.
- Pagination using offset and limit (per page).
- Custom selection of fields to be returned in the API response.
- Total count of links to assist with pagination.

## Features

- **Sorting**: Sort results by any valid field (`keyword`, `url`, `title`, `timestamp`, `ip`, `clicks`).
- **Pagination**: Use the `offset` and `perpage` parameters to paginate results.
- **Field Selection**: Select specific fields to return (e.g., `keyword`, `url`, `clicks`). By default, all fields are returned.
- **Total Count**: Returns the total number of links in the database, useful for pagination.

## Installation

1. Download and extract the plugin.
2. Upload the plugin folder to your YOURLS `user/plugins/` directory.
3. Activate the plugin from the YOURLS admin interface.
4. The plugin will automatically extend the YOURLS API with the new `list` action.

## API Usage

### Base URL

Use the following base URL for API requests:

```
http://<your-yourls-site>/yourls-api.php
```

### Required Parameters

- `signature`: Your YOURLS API signature token.
- `action`: Must be set to `list`.
- `format`: Optional. Specify `json` for JSON responses (default).

### Optional Parameters

- `sortby`: Field to sort by (`keyword`, `url`, `title`, `timestamp`, `ip`, `clicks`). Default is `timestamp`.
- `sortorder`: Sort order, either `ASC` (ascending) or `DESC` (descending). Default is `DESC`.
- `offset`: Number of links to skip (used for pagination). Default is `0`.
- `perpage`: Number of links to return per page. Default is `50`.
- `fields[]`: An array of fields to return (e.g., `fields[]=keyword&fields[]=url`). Default is all fields (`*`).

### Example Request

```
GET http://<your-yourls-site>/yourls-api.php?action=list&signature=your_signature&sortby=clicks&sortorder=ASC&offset=0&perpage=10&fields[]=keyword&fields[]=url
```

This example retrieves the first 10 results, sorted by clicks in ascending order, and returns only the `keyword` and `url` fields.

### Example Response

```json
{
  "statusCode": 200,
  "message": "success",
  "result": [
    {
      "keyword": "example1",
      "url": "http://example.com"
    },
    {
      "keyword": "example2",
      "url": "http://example.org"
    }
  ],
  "total": 100,
  "offset": 0,
  "perpage": 10
}
```

## Parameters Overview

| Parameter  | Type   | Description                                                                 | Default       |
|------------|--------|-----------------------------------------------------------------------------|---------------|
| `sortby`   | string | Field to sort results by (`keyword`, `url`, `title`, `ip`, `timestamp`, `clicks`). | `timestamp`   |
| `sortorder`| string | Sort order, `ASC` for ascending, `DESC` for descending.                      | `DESC`        |
| `offset`   | int    | Offset for pagination, number of links to skip.                             | `0`           |
| `perpage`  | int    | Number of links to return per page.                                          | `50`          |
| `fields[]` | array  | Fields to return in the response. Use array format: `fields[]=keyword`.      | `*` (all)     |

## License

This plugin is released under the GPL-v3 License. See the [LICENSE](https://www.gnu.org/licenses/gpl-3.0.html) file for more details.
