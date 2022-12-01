# Graphqlite with no framework

This is an example of Graphqlite running with no framework. This example was
made to demonstrate the problem with the input types. 

The implementation throws the following exception when trying to call a
mutation with an input.

```
Cached type in registry is not the type returned by type mapper.
```

## Starting the project

The project can be started with the local PHP webserver. The GraphiQL explorer
will load  for get requests and the API will handle post requests.

```
composer install
cd public
php -S localhost:8000
```

## Mutations

The following mutations are not working because of the input problems.

### Create facility

#### Mutation

```graphql
mutation CreateFacility($input: CreateFacilityInput!) {
  createFacility(input: $input) {
    id
    name
    subdomain
  }
}
```

#### Input

```json
{
  "input": {
    "name": "Hello World",
    "subdomain": "hello-world"
  }
}
```

### Update facility

```graphql
mutation UpdateFacility($input: UpdateFacilityInput!) {
  updateFacility(input: $input) {
    id
    name
    subdomain
  }
}
```

#### Input

```json
{
  "input": {
    "id": "1",
    "name": "Hello World",
    "subdomain": "hello-world"
  }
}
```

## Queries

The query works fine.

### Get facility

```graphql
query GetFacility($id: ID!) {
  facility(id: $id) {
    id
    name
    subdomain
  }
}
```

#### Input

```json
{
  "id": "1"
}
```