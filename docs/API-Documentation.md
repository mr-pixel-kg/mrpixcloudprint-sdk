# API Documentation

**Content**
- [Insert Document PrintJob](#Insert-Document-PrintJob)
- [Insert Template PrintJob](#Insert-Template-PrintJob)
- [PrintJob Details](#PrintJob-Details)
- [Printer Details](#Printer-Details)
- [Auth Test](#Auth-Test)

## Insert Document PrintJob

### Request

| Method | URL                                                         |
|--------|-------------------------------------------------------------|
| POST   | https://cloudprint.mpxcloud.de/api/v1/printjob/document     |

**Parameters**

| Name              | Type   | Required | Example              | Note           |
|-------------------|--------|----------|----------------------|----------------|
| printerName       | String | yes      | Pixeldrucker         |                |
| documentFile      | File   | yes      |                      |                |
| documentMediaType | String | yes      | text/vnd.star.markup |                |
| startTime         | String | no       | 202009251500         | Format: YmdHis |

### Response

**Response 200: PrintJob successful received**
```
{
    "statusCode": 200,
    "printJob": {
        "id": "864d6804-1073-4d11-adac-c3da664c5370",
        "printer": {
            "id": "11ed1d40-e08a-b78d-843b-9600006192ea",
            "name": "Pixeldrucker"
        },
        "document": {
            "mediaType": "application/vnd.star.starprnt",
            "exists": "not implemented",
            "url": "not implemented"
        },
        "status": {
            "currentStatus": 0,
            "isPending": true,
            "isPrinted": false
        },
        "timestamp": {
            "created": "2020-09-25 08:33:13",
            "fetched": null,
            "closed": null,
            "startTime": "2020-09-24 09:15:00"
        }
    }
}
```

## Insert Template PrintJob

### Request

| Method | URL                                                         |
|--------|-------------------------------------------------------------|
| POST   | https://cloudprint.mpxcloud.de/api/v1/printjob/template     |

**Parameters**

| Name              | Type   | Required | Example              | Note           |
|-------------------|--------|----------|----------------------|----------------|
| printerName       | String | yes      | Pixeldrucker         |                |
| templateName      | String | yes      | Standard             |                |
| templateVariables | Json   | yes      | {“var”:”content”}    |                |
| startTime         | String | no       | 202009251500         | Format: YmdHis |

### Response

**Response 200: PrintJob successful received**
```
{
    "statusCode": 200,
    "printJob": {
        "id": "864d6804-1073-4d11-adac-c3da664c5370",
        "printer": {
            "id": "11ed1d40-e08a-b78d-843b-9600006192ea",
            "name": "Pixeldrucker"
        },
        "document": {
            "mediaType": "application/vnd.star.starprnt",
            "exists": "not implemented",
            "url": "not implemented"
        },
        "status": {
            "currentStatus": 0,
            "isPending": true,
            "isPrinted": false
        },
        "timestamp": {
            "created": "2020-09-25 08:35:40",
            "fetched": null,
            "closed": null,
            "startTime": null
        }
    }
}
```

## PrintJob Details

### Request

| Method | URL                                                     |
|--------|---------------------------------------------------------|
| GET   | https://cloudprint.mpxcloud.de/api/v1/printjob/{uuid}    |

**Parameters**

| Name         | Type   | Required | Example                              | Note |
|--------------|--------|----------|--------------------------------------|------|
| printJobUuid | String | yes      | a8bb9db6-6510-48f2-97dc-c17b7818a1bc |      |

### Response

**Response 200: Information about PrintJob**
```
{
    "statusCode": 200,
    "printJob": {
        "id": "864d6804-1073-4d11-adac-c3da664c5370",
        "printer": {
            "id": "11ed1d40-e08a-b78d-843b-9600006192ea",
            "name": "Pixeldrucker"
        },
        "document": {
            "mediaType": "application/vnd.star.starprnt",
            "exists": "not implemented",
            "url": "not implemented"
        },
        "status": {
            "currentStatus": 0,
            "isPending": true,
            "isPrinted": false
        },
        "timestamp": {
            "created": "2020-09-24 08:13:44",
            "fetched": null,
            "closed": null,
            "startTime": "2020-09-24 09:15:00"
        }
    }
}
```

## Printer Details

### Request

| Method | URL                                                 |
|--------|-----------------------------------------------------|
| GET   | https://cloudprint.mpxcloud.de/api/v1/printer/{uuid} |

**Parameters**

| Name        | Type    | Required | Example                              | Note |
|-------------|---------|----------|--------------------------------------|------|
| printerUuid | String  | yes      | a8bb9db6-6510-48f2-97dc-c17b7818a1bc |      |

### Response

**Response 200: Information about Printer**
```
{
    "statusCode": 200,
    "printer": {
        "id": "11ed1d40-e08a-b78d-843b-9600006192ea",
        "name": "Pixeldrucker",
        "owner": {
            "email": "manuel.kienlein@mr-pixel.de"
        },
        "macAddress": "00:11:62:1C:29:08",
        "timestamp": {
            "lastSeen": "2020-09-24 15:33:28",
            "created": "not implemented",
            "lastPrint": "not implemented"
        },
        "currentPrintJob": null,
        "lastStatus": {
            "online": true,
            "coverOpen": false,
            "compulsionSwitch": false,
            "overTemperature": false,
            "recoverable": true,
            "cutterError": false,
            "mechanicalError": false,
            "receiveBufferOverflow": false,
            "blackMarkError": false,
            "presenterPaperJam": false,
            "voltageError": false,
            "paperEmpty": false,
            "paperLow": false
        }
    }
}
```

## Auth Test

### Request

| Method | URL                                                 |
|--------|---------------------------------------------------- |
| POST   | https://cloudprint.mpxcloud.de/api/v1/auth/test     |

**Authorization**

Provide login credentials via HTTP Auth

### Response

**Response 200: Authentication successful**
```
{
    "statusCode": 200,
    "message": "Access granted"
}
```

**Response 401: Authentication failed**
```
{
    "statusCode": 401,
    "message": "Authentification required"
}
```

**Response 401: Authentication failed**

No response content