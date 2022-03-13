# Exceptions
Below is a short overview about the exceptions.

## CloudPrintException
- interface that gets implemented by all exceptions below

## ConstraintViolationException
- is thrown when validating of a CloudPrintRequest failed before building and sending

## InvalidArgumentException (not implemented)
- will be thrown if construction of object fails, because the parameters are not valid

## NetworkException
- is thrown when sending the api request failed
- issues by the http client e.g. connection issues

## ResponseDecodeException
- it thrown when decoding of the server response failed

## ServerException
- is thrown if api returns an other status code than '200 OK'
- indicates that request was not successful