# Api Spec

## /auth

### Request

-   Method: POST
-   End Point: {{ base_url }}/auth
-   Body:

```json
{
    "email": "string",
    "password": "string"
}
```

### Response

#### 200

```json
{
    "statusCode": 200,
    "statusMessage": "OK",
    "message": "Success",
    "data": {
        "user": {
            "id": "string",
            "email": "string",
            "name": "string"
        },
        "token": "string"
    }
}
```
