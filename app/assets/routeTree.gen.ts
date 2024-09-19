/* prettier-ignore-start */

/* eslint-disable */

// @ts-nocheck

// noinspection JSUnusedGlobalSymbols

// This file is auto-generated by TanStack Router

// Import Routes

import { Route as rootRoute } from './routes/__root'
import { Route as AboutImport } from './routes/about'
import { Route as IndexImport } from './routes/index'
import { Route as UsersIndexImport } from './routes/users/index'
import { Route as UsersCreateImport } from './routes/users/create'
import { Route as Error403Import } from './routes/error/403'
import { Route as AuthLoginImport } from './routes/auth/login'
import { Route as UsersIdEditImport } from './routes/users/$id/edit'

// Create/Update Routes

const AboutRoute = AboutImport.update({
  path: '/about',
  getParentRoute: () => rootRoute,
} as any)

const IndexRoute = IndexImport.update({
  path: '/',
  getParentRoute: () => rootRoute,
} as any)

const UsersIndexRoute = UsersIndexImport.update({
  path: '/users/',
  getParentRoute: () => rootRoute,
} as any)

const UsersCreateRoute = UsersCreateImport.update({
  path: '/users/create',
  getParentRoute: () => rootRoute,
} as any)

const Error403Route = Error403Import.update({
  path: '/error/403',
  getParentRoute: () => rootRoute,
} as any)

const AuthLoginRoute = AuthLoginImport.update({
  path: '/auth/login',
  getParentRoute: () => rootRoute,
} as any)

const UsersIdEditRoute = UsersIdEditImport.update({
  path: '/users/$id/edit',
  getParentRoute: () => rootRoute,
} as any)

// Populate the FileRoutesByPath interface

declare module '@tanstack/react-router' {
  interface FileRoutesByPath {
    '/': {
      id: '/'
      path: '/'
      fullPath: '/'
      preLoaderRoute: typeof IndexImport
      parentRoute: typeof rootRoute
    }
    '/about': {
      id: '/about'
      path: '/about'
      fullPath: '/about'
      preLoaderRoute: typeof AboutImport
      parentRoute: typeof rootRoute
    }
    '/auth/login': {
      id: '/auth/login'
      path: '/auth/login'
      fullPath: '/auth/login'
      preLoaderRoute: typeof AuthLoginImport
      parentRoute: typeof rootRoute
    }
    '/error/403': {
      id: '/error/403'
      path: '/error/403'
      fullPath: '/error/403'
      preLoaderRoute: typeof Error403Import
      parentRoute: typeof rootRoute
    }
    '/users/create': {
      id: '/users/create'
      path: '/users/create'
      fullPath: '/users/create'
      preLoaderRoute: typeof UsersCreateImport
      parentRoute: typeof rootRoute
    }
    '/users/': {
      id: '/users/'
      path: '/users'
      fullPath: '/users'
      preLoaderRoute: typeof UsersIndexImport
      parentRoute: typeof rootRoute
    }
    '/users/$id/edit': {
      id: '/users/$id/edit'
      path: '/users/$id/edit'
      fullPath: '/users/$id/edit'
      preLoaderRoute: typeof UsersIdEditImport
      parentRoute: typeof rootRoute
    }
  }
}

// Create and export the route tree

export interface FileRoutesByFullPath {
  '/': typeof IndexRoute
  '/about': typeof AboutRoute
  '/auth/login': typeof AuthLoginRoute
  '/error/403': typeof Error403Route
  '/users/create': typeof UsersCreateRoute
  '/users': typeof UsersIndexRoute
  '/users/$id/edit': typeof UsersIdEditRoute
}

export interface FileRoutesByTo {
  '/': typeof IndexRoute
  '/about': typeof AboutRoute
  '/auth/login': typeof AuthLoginRoute
  '/error/403': typeof Error403Route
  '/users/create': typeof UsersCreateRoute
  '/users': typeof UsersIndexRoute
  '/users/$id/edit': typeof UsersIdEditRoute
}

export interface FileRoutesById {
  __root__: typeof rootRoute
  '/': typeof IndexRoute
  '/about': typeof AboutRoute
  '/auth/login': typeof AuthLoginRoute
  '/error/403': typeof Error403Route
  '/users/create': typeof UsersCreateRoute
  '/users/': typeof UsersIndexRoute
  '/users/$id/edit': typeof UsersIdEditRoute
}

export interface FileRouteTypes {
  fileRoutesByFullPath: FileRoutesByFullPath
  fullPaths:
    | '/'
    | '/about'
    | '/auth/login'
    | '/error/403'
    | '/users/create'
    | '/users'
    | '/users/$id/edit'
  fileRoutesByTo: FileRoutesByTo
  to:
    | '/'
    | '/about'
    | '/auth/login'
    | '/error/403'
    | '/users/create'
    | '/users'
    | '/users/$id/edit'
  id:
    | '__root__'
    | '/'
    | '/about'
    | '/auth/login'
    | '/error/403'
    | '/users/create'
    | '/users/'
    | '/users/$id/edit'
  fileRoutesById: FileRoutesById
}

export interface RootRouteChildren {
  IndexRoute: typeof IndexRoute
  AboutRoute: typeof AboutRoute
  AuthLoginRoute: typeof AuthLoginRoute
  Error403Route: typeof Error403Route
  UsersCreateRoute: typeof UsersCreateRoute
  UsersIndexRoute: typeof UsersIndexRoute
  UsersIdEditRoute: typeof UsersIdEditRoute
}

const rootRouteChildren: RootRouteChildren = {
  IndexRoute: IndexRoute,
  AboutRoute: AboutRoute,
  AuthLoginRoute: AuthLoginRoute,
  Error403Route: Error403Route,
  UsersCreateRoute: UsersCreateRoute,
  UsersIndexRoute: UsersIndexRoute,
  UsersIdEditRoute: UsersIdEditRoute,
}

export const routeTree = rootRoute
  ._addFileChildren(rootRouteChildren)
  ._addFileTypes<FileRouteTypes>()

/* prettier-ignore-end */

/* ROUTE_MANIFEST_START
{
  "routes": {
    "__root__": {
      "filePath": "__root.tsx",
      "children": [
        "/",
        "/about",
        "/auth/login",
        "/error/403",
        "/users/create",
        "/users/",
        "/users/$id/edit"
      ]
    },
    "/": {
      "filePath": "index.tsx"
    },
    "/about": {
      "filePath": "about.tsx"
    },
    "/auth/login": {
      "filePath": "auth/login.tsx"
    },
    "/error/403": {
      "filePath": "error/403.tsx"
    },
    "/users/create": {
      "filePath": "users/create.tsx"
    },
    "/users/": {
      "filePath": "users/index.tsx"
    },
    "/users/$id/edit": {
      "filePath": "users/$id/edit.tsx"
    }
  }
}
ROUTE_MANIFEST_END */
