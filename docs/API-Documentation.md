# API Documentation


## Insert Document PrintJob

### Request

| Method | URL                                                         |
|--------|-------------------------------------------------------------|
| POST   | https://dev.cloudprint.mpxcloud.de/api/v1/printjob/document |

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
        "id": 1230,
        "printer": {
            "id": 1,
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
| POST   | https://dev.cloudprint.mpxcloud.de/api/v1/printjob/template |

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
        "id": 1231,
        "printer": {
            "id": 1,
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
| GET   | https://dev.cloudprint.mpxcloud.de/api/v1/printjob/1220 |

**Parameters**

| Name       | Type    | Required | Example | Note |
|------------|---------|----------|---------|------|
| printJobId | Integer | yes      | 1220    |      |

### Response

**Response 200: Information about PrintJob**
```
{
    "statusCode": 200,
    "printJob": {
        "id": 1220,
        "printer": {
            "id": 1,
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
| GET   | https://dev.cloudprint.mpxcloud.de/api/v1/printer/1 |

**Parameters**

| Name      | Type    | Required | Example | Note |
|-----------|---------|----------|---------|------|
| printerId | Integer | yes      | 1       |      |

### Response

**Response 200: Information about Printer**
```
{
    "statusCode": 200,
    "printer": {
        "id": 1,
        "name": "Pixeldrucker",
        "owner": {
            "id": 1,
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