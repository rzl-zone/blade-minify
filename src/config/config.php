<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Env Variable for Minify Blade
    |--------------------------------------------------------------------------
    |
    | Set this default value or add `RZLZONE_MINIFY_ENABLE=false` at .env to
    |   the false if you want disable minifying render output.
    |
    | This is by default is "true"
    |
    */
  'enable'               => env('RZLZONE_MINIFY_ENABLE', true),

  /*
    |--------------------------------------------------------------------------
    | Env Variable for Running Minify Blade Only On Production
    |--------------------------------------------------------------------------
    |
    | Set this default value or add `RZLZONE_MINIFY_ONLY_PROD=true` at .env to
    |   the true to avoiding minifying render output if not production.
    |
    | This is by default is "false"
    |
    */
  'run_production_only'  => env('RZLZONE_MINIFY_ONLY_PROD', false),

  /*
    |--------------------------------------------------------------------------
    | Ignoring list route name for ignore from minifying render output.
    |--------------------------------------------------------------------------
    |
    | Set listing of Route Name to avoiding from minifying render output.
    |
    | This is by default is [].
    |
    */
  'ignore_route_name'    => [
    // 'dashboard',
    // 'home',
  ],

  /*
    |--------------------------------------------------------------------------
    | Custom Vite Configuration
    |--------------------------------------------------------------------------
    |
    | This array contains the configuration settings for the custom Vite asset
    | bundler integration, including build directories, CSP nonce settings,
    | and manifest/hot file tracking.
    |
    | WARNING: If you modify these values, ensure that your `vite.config.js`
    | configuration (such as build.outDir, build.manifest, or server settings)
    | is updated accordingly to match these paths and filenames.
    |
    */
  "custom-vite" => [
    /*
      |--------------------------------------------------------------------------
      | Build Directory
      |--------------------------------------------------------------------------
      |
      | This value determines the directory where compiled frontend assets
      | will be stored. The framework and asset helpers may use this path
      | when resolving built files and generated manifests.
      |
      | If changed, make sure to update the `build.outDir` in `vite.config.js`
      | (e.g., `public/custom-build-dir`).
      |
      */
    "build_dir" => env("APP_BUILD_DIR", "build"),

    /*
      |--------------------------------------------------------------------------
      | Use Asset Nonce
      |--------------------------------------------------------------------------
      |
      | This option determines whether a nonce attribute should be applied
      | to generated asset tags. Enabling this can help satisfy Content
      | Security Policy (CSP) requirements for scripts and styles.
      |
      */
    "use_nonce" => env("APP_USE_NONCE", false),

    /*
      |--------------------------------------------------------------------------
      | Build Manifest File
      |--------------------------------------------------------------------------
      |
      | This value specifies the name of the asset manifest file generated
      | by the frontend build process. The manifest is used to map original
      | asset names to their versioned counterparts.
      |
      | If changed, ensure your `vite.config.js` has a matching filename
      | via `build.manifest` configuration.
      |
      */
    "manifest_name" => __rzl_bm_get_path_file__(env("APP_BUILD_MANIFEST_NAME"), default: "manifest.json"),

    /*
      |--------------------------------------------------------------------------
      | Hot Module Replacement File
      |--------------------------------------------------------------------------
      |
      | This value defines the location of the hot file used during local
      | development. When present, the framework will use it to detect and
      | communicate with the running development server.
      |
      | If customized, you must configure Vite's plugin or server options
      | to output the hot file to this exact path.
      |
      */
    "hot_file" => __rzl_bm_get_path_file__(env("APP_HOT_FILE")) ? public_path(__rzl_bm_get_path_file__(env("APP_HOT_FILE"))) : "hot",
  ]
];
