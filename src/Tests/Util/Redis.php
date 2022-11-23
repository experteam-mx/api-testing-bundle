<?php

namespace Experteam\ApiTestingBundle\Tests\Util;

use Experteam\ApiRedisBundle\Service\RedisClient\RedisClientInterface;
use Symfony\Component\String\ByteString;

class Redis
{
    /**
     * @var Redis
     */
    private static Redis $instance;

    /**
     * @var string
     */
    private string $token;

    private const TOKEN_DATA = [
        "name" => "Roberlay León Piñero",
        "model_type" => "EMPLOYEE",
        "model_id" => 3426,
        "is_active" => true,
        "auth_type" => "LOCAL",
        "language_id" => 2,
        "email" => "roberlay.leon@experteam.com.ec",
        "id" => 2116,
        "username" => "rleonus",
        "permissions" => [
            "security_app_keys",
            "security_auth",
            "security_roles_get_all",
            "security_roles_post",
            "security_roles_get",
            "security_roles_update",
            "security_roles_disable",
            "security_sessions_get_all",
            "security_sessions_get",
            "security_sessions_update",
            "security_users_get_all",
            "security_users_get",
            "security_users_disable",
            "catalogs_awb_types",
            "catalogs_countries_get_all",
            "catalogs_countries_get",
            "catalogs_currencies_get_all",
            "catalogs_currencies_get",
            "catalogs_extracharges_get_all",
            "catalogs_extracharges_get",
            "catalogs_holidays_get_all",
            "catalogs_holidays_get",
            "catalogs_holidays_client_get_all",
            "catalogs_languages_get_all",
            "catalogs_languages_get",
            "catalogs_location_types_get_all",
            "catalogs_location_types_get",
            "catalogs_package_locations_get_all",
            "catalogs_package_locations_get",
            "catalogs_postal_locations_get_all",
            "catalogs_postal_locations_get",
            "catalogs_postal_locations_tranctions_get",
            "catalogs_products_get_all",
            "catalogs_products_get",
            "catalogs_regions_get_all",
            "catalogs_regions_get",
            "catalogs_restricted_account_products_get_all",
            "catalogs_restricted_account_products_get",
            "catalogs_shipment_types_get_all",
            "catalogs_shipment_types_get",
            "catalogs_states_get_all",
            "catalogs_states_get",
            "catalogs_states_search_by_code_get",
            "catalogs_units_get_all",
            "catalogs_units_get",
            "catalogs_zones_get_all",
            "catalogs_zones_get",
            "catalogs_shipment_content_types",
            "catalogs_shipment_groups",
            "catalogs_shipment_scopes",
            "catalogs_shipment_scope_products",
            "companies_account_categories_get_all",
            "companies_account_categories_get",
            "companies_accounts_session_actives_get_all",
            "companies_accounts_get_all",
            "companies_accounts_get",
            "companies_account_entities_get_all_actives",
            "companies_account_types_get_all",
            "companies_account_types_get",
            "companies_companies_get_all",
            "companies_companies_get",
            "companies_company_countries_get_all",
            "companies_company_countries_get",
            "companies_company_country_currencies_get_all",
            "companies_company_country_currencies_get",
            "companies_company_country_extra_charges_get_all",
            "companies_company_country_extra_charges_get",
            "companies_company_country_languages_get_all",
            "companies_company_country_languages_get",
            "companies_company_country_products_get_all",
            "companies_company_country_products_get",
            "companies_company_country_shipment_types_get_all",
            "companies_company_country_shipment_types_get",
            "companies_company_country_summer_times_get_all",
            "companies_company_country_summer_times_get",
            "companies_company_country_taxes_get_all",
            "companies_company_country_taxes_get",
            "companies_country_references_get_all",
            "companies_country_references_get",
            "companies_employees_get_all",
            "companies_employees_get",
            "companies_exchanges_get_all",
            "companies_exchanges_get",
            "companies_exchanges_current",
            "companies_extracharge_entities_get_all_actives",
            "companies_installations_get_all",
            "companies_installations_get",
            "companies_location_accounts_get_all",
            "companies_location_accounts_get",
            "companies_locations_get_all",
            "companies_locations_get",
            "companies_location_employees_get_all",
            "companies_location_employees_get",
            "companies_location_office_hours_get_all",
            "companies_location_office_hours_get",
            "companies_pages_get_all",
            "companies_pages_get",
            "companies_parameter_configs_get_all",
            "companies_parameter_configs_get",
            "companies_parameters",
            "companies_parameters_values",
            "companies_product_entities_get_all_actives",
            "companies_supply_entities_get_all_actives",
            "companies_systems_get_all",
            "companies_systems_get",
            "companies_system_entities_get_all_actives",
            "companies_workflow_configs_get_all",
            "companies_workflow_configs_get",
            "companies_workflows_get",
            "services_accounts",
            "services_blacklists",
            "services_bookings",
            "services_Capabilities",
            "services_emails",
            "services_identifiers",
            "services_jme_mobile",
            "services_labels",
            "services_promotions",
            "services_quotes",
            "services_sms",
            "services_shipment_manifests",
            "services_shipment_queries",
            "services_survey",
            "shipments_accounts_post",
            "shipments_accounts_nit_post",
            "shipments_book_pickups",
            "shipments_quotes",
            "shipments_shipment_addresses_person_get",
            "shipments_shipment_addresses_shippers_get",
            "shipments_shipment_addresses_consignees_get",
            "shipments_shipments_get_all",
            "shipments_shipments_post",
            "shipments_shipments_update",
            "shipments_shipments_manisfest_post",
            "shipments_shipments_labels_get",
            "shipments_shipments_tickets_get",
            "shipments_messages",
            "composition_company_country_products",
            "composition_company_country_supplies",
            "composition_operation_packages",
            "composition_shipments",
            "composition_views_shipments",
            "composition_messages",
            "inventories_courier_check_in",
            "inventories_courier_check_out",
            "inventories_couriers",
            "inventories_operations",
            "inventories_operation_types",
            "inventories_packages",
            "inventories_positions",
            "inventories_redis_stock",
            "inventories_statuses",
            "inventories_stock_update",
            "inventories_messages",
            "invoices_company_country_document_types_get_all",
            "invoices_company_country_document_types_get",
            "invoices_company_country_payment_types_get_all",
            "invoices_company_country_payment_types_get",
            "invoices_country_payment_types_get_all",
            "invoices_country_payment_types_get",
            "invoices_country_payment_type_fields_get_all",
            "invoices_country_payment_type_fields_get",
            "invoices_customers_get_all",
            "invoices_customers_post",
            "invoices_customers_get",
            "invoices_customers_update",
            "invoices_document_categories_get_all",
            "invoices_document_categories_get",
            "invoices_document_payments_get_all",
            "invoices_document_payments_get",
            "invoices_document_type_ranges_get_all",
            "invoices_document_type_ranges_get",
            "invoices_document_types_get_all",
            "invoices_document_types_get",
            "invoices_document_types_company_country_get_all",
            "invoices_documents_get_all",
            "invoices_documents_post",
            "invoices_documents_get",
            "invoices_documents_update",
            "invoices_items_get_all",
            "invoices_items_post",
            "invoices_items_get",
            "invoices_items_update",
            "invoices_operation_cancel_document_post",
            "invoices_operation_document_post",
            "invoices_operation_payments_post",
            "invoices_operation_print_document_get",
            "invoices_operation_print_ticket_get",
            "invoices_pickup_operations",
            "invoices_shipment_operations",
            "invoices_adjustments_get_all",
            "invoices_adjustments_get",
            "invoices_payment_types_get_all",
            "invoices_payment_types_get",
            "invoices_payment_types_company_country_get_all",
            "invoices_payments_get_all",
            "invoices_payments_get",
            "invoices_providers_get_all",
            "invoices_providers_post",
            "invoices_providers_get",
            "invoices_providers_update",
            "invoices_tolerances_get_all",
            "invoices_tolerances_get",
            "supplies_company_country_supplies_get_all",
            "supplies_company_country_supplies_get",
            "supplies_country_supply_locations_get_all",
            "supplies_country_supply_locations_get",
            "supplies_company_country_supply_location_transactions_get_all",
            "supplies_company_country_supply_location_transactions_get",
            "supplies_supplies_get_all",
            "supplies_supplies_get",
            "supplies_supplies_actives_get_all",
            "supplies_supplies_id_company_country_supply_location_transactions_post",
            "supplies_supply_transaction_types_get_all",
            "supplies_supply_transaction_types_post",
            "supplies_supply_transaction_types_get",
            "supplies_supply_transaction_types_update",
            "supplies_types_get_all",
            "supplies_types_get",
            "lockers_cutoff_times_get_all",
            "lockers_cutoff_times_get",
            "lockers_incidents_get_all",
            "lockers_incidents_get",
            "lockers_locker_positions_get_all",
            "lockers_locker_positions_get",
            "lockers_locker_position_statuses_get_all",
            "lockers_locker_position_statuses_get",
            "lockers_locker_position_types_get_all",
            "lockers_locker_position_types_get",
            "lockers_locker_racks_get_all",
            "lockers_locker_racks_get",
            "lockers_locker_racks_content_get",
            "lockers_operation",
            "lockers_package_candidates_get_all",
            "lockers_package_candidates_post",
            "lockers_package_candidates_get",
            "lockers_package_candidates_update",
            "lockers_package_statuses_get_all",
            "lockers_package_statuses_get",
            "inventories_incidents_get_all",
            "inventories_incidents_get",
            "notifications_notifications_get_all",
            "notifications_notifications_get",
            "notifications_notifications_content",
            "notifications_notification_statuses_get_all",
            "notifications_notification_statuses_get",
            "notifications_notification_types_get_all",
            "notifications_notification_types_get",
            "pickups_operations_get_all",
            "pickups_operations_get",
            "pickups_operations_post",
            "dropoffs_check_in",
            "dropoffs_operations",
            "dropoffs_packages",
            "catalogs_business_party_trader_types_get_all",
            "catalogs_business_party_trader_types_get",
            "catalogs_document_functions_get_all",
            "catalogs_document_functions_get",
            "catalogs_document_types_get_all",
            "catalogs_document_types_get",
            "catalogs_export_reasons_get_all",
            "catalogs_export_reasons_get",
            "catalogs_quantity_units_get_all",
            "catalogs_quantity_units_get",
            "catalogs_registration_number_types_get_all",
            "catalogs_registration_number_types_get",
            "catalogs_trading_transaction_types_get_all",
            "catalogs_trading_transaction_types_get",
            "services_additional_shipment_data",
            "inventories_package_incidents_get_all",
            "inventories_package_incidents_update",
            "customs_criteria_get_all",
            "customs_criteria_get",
            "customs_rules_get_all",
            "customs_rules_get",
            "customs_catalogs_get_all",
            "customs_catalogs_get",
            "customs_operations",
            "customs_catalogs_values_get",
            "lockers_views_package_status_count",
            "lockers_views_cutoff_packages",
            "services_commercial_invoice_label",
            "shipments_commercial_invoice_label",
            "lockers_views_package_candidates",
            "catalogs_identification_types_get_all",
            "catalogs_identification_types_get",
            "shipments_commercial_invoice",
            "companies_country_reference_currencies_get_all",
            "companies_country_reference_currencies_get",
            "catalogs_management_areas_get_all",
            "catalogs_management_areas_get",
            "events_operation_events_post",
            "events_queue_manager",
            "events_statuses_get_all",
            "events_statuses_get",
            "events_events_get_all",
            "events_events_get",
            "events_actions_get_all",
            "events_actions_get",
            "events_event_action_statuses_get_all",
            "events_event_action_statuses_get",
            "shipments_shipments_cancellation_delete",
            "companies_country_reference_products_get_all",
            "companies_country_reference_products_get",
            "companies_country_reference_extra_charges_get_all",
            "companies_country_reference_extra_charges_get",
            "checkpoints_operation_set_checkpoints_post",
            "checkpoints_operation_get_checkpoints_post",
            "report_cash_report_get_all",
            "report_shipments_report_get_all",
            "report_packages_get_all",
            "report_operations_get_all",
            "catalogs_shipment_descriptions_get_all",
            "catalogs_shipment_descriptions_get",
            "dropoffs_queue_manager_validation",
            "reports_price_overrides_get_all",
            "cra10_dropoff",
            "cra10_reports",
            "cra10_shipment_list",
            "cra10_shipment_generate",
            "cra10_shipment_save",
            "cra10_shipment_manifest",
            "cra10_shipment_cancel",
            "services_retail_rates",
            "shipments_retail_rates",
            "catalogs_questions_get_all",
            "catalogs_questions_get",
            "pickups_country_damaged_delivered_events_get_all",
            "pickups_country_damaged_delivered_events_get"
        ],
        "session" => [
            "installation_id" => 207,
            "status" => "OPENED",
            "last_activity" => "2022-10-31T13:44:28+00:00",
            "user_agent" => "PostmanRuntime/7.29.2",
            "gmt_offset" => "-00:00",
            "user_id" => 2116,
            "updated_at" => "2022-10-31T13:44:28+00:00",
            "created_at" => "2022-10-31T13:44:28+00:00",
            "id" => 60016,
            "country_id" => 213,
            "company_id" => 2,
            "company_country_id" => 2,
            "location_id" => 740,
            "company_country_currency_id" => 3,
            "location_employee_id" => 6309
        ],
        "role" => [
            "id" => 11,
            "name" => "SVP AGENT",
            "guard_name" => "api",
            "is_active" => true,
            "created_at" => "2022-09-02T23:45:33+00:00",
            "updated_at" => "2022-09-26T19:44:25+00:00",
            "company_country_id" => 2,
            "role_type_id" => 5,
            "role_type" => [
                "id" => 5,
                "level" => 4,
                "name" => "Installation",
                "is_active" => true,
                "created_at" => "2022-09-02T18:42:10.717000Z",
                "updated_at" => "2022-09-02T18:42:10.717000Z"
            ],
            "permissions" => [
                [
                    "id" => 26,
                    "name" => "security_app_keys",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "26"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 27,
                    "name" => "security_auth",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "27"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 30,
                    "name" => "security_roles_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "30"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 31,
                    "name" => "security_roles_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "31"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 32,
                    "name" => "security_roles_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "32"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 33,
                    "name" => "security_roles_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "33"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 34,
                    "name" => "security_roles_disable",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "34"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 35,
                    "name" => "security_sessions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "35"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 36,
                    "name" => "security_sessions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "36"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 37,
                    "name" => "security_sessions_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "37"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 38,
                    "name" => "security_users_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "38"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 40,
                    "name" => "security_users_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "40"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 42,
                    "name" => "security_users_disable",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "42"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 43,
                    "name" => "catalogs_awb_types",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "43"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 44,
                    "name" => "catalogs_countries_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "44"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 46,
                    "name" => "catalogs_countries_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "46"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 49,
                    "name" => "catalogs_currencies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "49"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 51,
                    "name" => "catalogs_currencies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "51"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 54,
                    "name" => "catalogs_extracharges_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "54"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 56,
                    "name" => "catalogs_extracharges_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "56"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 58,
                    "name" => "catalogs_holidays_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "58"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 60,
                    "name" => "catalogs_holidays_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "60"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 63,
                    "name" => "catalogs_holidays_client_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "63"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 64,
                    "name" => "catalogs_languages_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "64"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 66,
                    "name" => "catalogs_languages_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "66"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 69,
                    "name" => "catalogs_location_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "69"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 71,
                    "name" => "catalogs_location_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "71"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 74,
                    "name" => "catalogs_package_locations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "74"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 76,
                    "name" => "catalogs_package_locations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "76"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 79,
                    "name" => "catalogs_postal_locations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "79"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 81,
                    "name" => "catalogs_postal_locations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "81"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 82,
                    "name" => "catalogs_postal_locations_tranctions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "82"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 83,
                    "name" => "catalogs_products_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "83"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 85,
                    "name" => "catalogs_products_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "85"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 87,
                    "name" => "catalogs_regions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "87"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 89,
                    "name" => "catalogs_regions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "89"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 92,
                    "name" => "catalogs_restricted_account_products_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "92"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 94,
                    "name" => "catalogs_restricted_account_products_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:13+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "94"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 97,
                    "name" => "catalogs_shipment_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "97"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 99,
                    "name" => "catalogs_shipment_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "99"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 102,
                    "name" => "catalogs_states_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "102"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 104,
                    "name" => "catalogs_states_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "104"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 107,
                    "name" => "catalogs_states_search_by_code_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "107"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 108,
                    "name" => "catalogs_units_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "108"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 110,
                    "name" => "catalogs_units_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "110"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 113,
                    "name" => "catalogs_zones_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "113"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 115,
                    "name" => "catalogs_zones_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "115"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 121,
                    "name" => "catalogs_shipment_content_types",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "121"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 122,
                    "name" => "catalogs_shipment_groups",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "122"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 123,
                    "name" => "catalogs_shipment_scopes",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "123"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 124,
                    "name" => "catalogs_shipment_scope_products",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "124"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 125,
                    "name" => "companies_account_categories_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "125"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 127,
                    "name" => "companies_account_categories_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "127"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 130,
                    "name" => "companies_accounts_session_actives_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "130"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 131,
                    "name" => "companies_accounts_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "131"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 133,
                    "name" => "companies_accounts_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "133"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 138,
                    "name" => "companies_account_entities_get_all_actives",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "138"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 139,
                    "name" => "companies_account_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "139"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 141,
                    "name" => "companies_account_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "141"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 144,
                    "name" => "companies_companies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "144"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 146,
                    "name" => "companies_companies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "146"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 149,
                    "name" => "companies_company_countries_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "149"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 151,
                    "name" => "companies_company_countries_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "151"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 154,
                    "name" => "companies_company_country_currencies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "154"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 156,
                    "name" => "companies_company_country_currencies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "156"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 159,
                    "name" => "companies_company_country_extra_charges_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "159"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 161,
                    "name" => "companies_company_country_extra_charges_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "161"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 163,
                    "name" => "companies_company_country_languages_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "163"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 165,
                    "name" => "companies_company_country_languages_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "165"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 168,
                    "name" => "companies_company_country_products_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "168"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 170,
                    "name" => "companies_company_country_products_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "170"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 172,
                    "name" => "companies_company_country_shipment_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "172"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 174,
                    "name" => "companies_company_country_shipment_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "174"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 177,
                    "name" => "companies_company_country_summer_times_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "177"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 179,
                    "name" => "companies_company_country_summer_times_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "179"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 183,
                    "name" => "companies_company_country_taxes_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "183"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 185,
                    "name" => "companies_company_country_taxes_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "185"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 188,
                    "name" => "companies_country_references_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "188"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 190,
                    "name" => "companies_country_references_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:14+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "190"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 193,
                    "name" => "companies_employees_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "193"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 195,
                    "name" => "companies_employees_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "195"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 198,
                    "name" => "companies_exchanges_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "198"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 200,
                    "name" => "companies_exchanges_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "200"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 203,
                    "name" => "companies_exchanges_current",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "203"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 206,
                    "name" => "companies_extracharge_entities_get_all_actives",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "206"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 207,
                    "name" => "companies_installations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "207"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 209,
                    "name" => "companies_installations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "209"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 212,
                    "name" => "companies_location_accounts_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "212"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 214,
                    "name" => "companies_location_accounts_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "214"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 217,
                    "name" => "companies_locations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "217"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 219,
                    "name" => "companies_locations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "219"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 222,
                    "name" => "companies_location_employees_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "222"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 224,
                    "name" => "companies_location_employees_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 3,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "224"
                    ],
                    "permission_type" => [
                        "id" => 3,
                        "name" => "FRONT_BACK",
                        "description" => "Both permission to use endpoint in the client and in the back end",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 227,
                    "name" => "companies_location_office_hours_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "227"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 229,
                    "name" => "companies_location_office_hours_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "229"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 233,
                    "name" => "companies_pages_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "233"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 235,
                    "name" => "companies_pages_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "235"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 238,
                    "name" => "companies_parameter_configs_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "238"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 240,
                    "name" => "companies_parameter_configs_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "240"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 243,
                    "name" => "companies_parameters",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "243"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 244,
                    "name" => "companies_parameters_values",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "244"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 248,
                    "name" => "companies_product_entities_get_all_actives",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "248"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 252,
                    "name" => "companies_supply_entities_get_all_actives",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "252"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 253,
                    "name" => "companies_systems_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "253"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 255,
                    "name" => "companies_systems_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "255"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 260,
                    "name" => "companies_system_entities_get_all_actives",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "260"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 261,
                    "name" => "companies_workflow_configs_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "261"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 263,
                    "name" => "companies_workflow_configs_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "263"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 267,
                    "name" => "companies_workflows_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "267"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 268,
                    "name" => "services_accounts",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "268"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 269,
                    "name" => "services_blacklists",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "269"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 270,
                    "name" => "services_bookings",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "270"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 271,
                    "name" => "services_Capabilities",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "271"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 272,
                    "name" => "services_emails",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "272"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 273,
                    "name" => "services_identifiers",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "273"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 274,
                    "name" => "services_jme_mobile",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "274"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 275,
                    "name" => "services_labels",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "275"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 276,
                    "name" => "services_promotions",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "276"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 277,
                    "name" => "services_quotes",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "277"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 278,
                    "name" => "services_sms",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "278"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 279,
                    "name" => "services_shipment_manifests",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:15+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "279"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 280,
                    "name" => "services_shipment_queries",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "280"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 281,
                    "name" => "services_survey",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "281"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 282,
                    "name" => "shipments_accounts_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "282"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 283,
                    "name" => "shipments_accounts_nit_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "283"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 284,
                    "name" => "shipments_book_pickups",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "284"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 285,
                    "name" => "shipments_quotes",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "285"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 286,
                    "name" => "shipments_shipment_addresses_person_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "286"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 287,
                    "name" => "shipments_shipment_addresses_shippers_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "287"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 288,
                    "name" => "shipments_shipment_addresses_consignees_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "288"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 289,
                    "name" => "shipments_shipments_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "289"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 290,
                    "name" => "shipments_shipments_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "290"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 291,
                    "name" => "shipments_shipments_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "291"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 292,
                    "name" => "shipments_shipments_manisfest_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "292"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 293,
                    "name" => "shipments_shipments_labels_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "293"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 294,
                    "name" => "shipments_shipments_tickets_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "294"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 295,
                    "name" => "shipments_messages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "295"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 297,
                    "name" => "composition_company_country_products",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "297"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 298,
                    "name" => "composition_company_country_supplies",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "298"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 299,
                    "name" => "composition_operation_packages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "299"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 300,
                    "name" => "composition_shipments",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "300"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 301,
                    "name" => "composition_views_shipments",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "301"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 302,
                    "name" => "composition_messages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "302"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 304,
                    "name" => "inventories_courier_check_in",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "304"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 305,
                    "name" => "inventories_courier_check_out",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "305"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 306,
                    "name" => "inventories_couriers",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "306"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 307,
                    "name" => "inventories_operations",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "307"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 308,
                    "name" => "inventories_operation_types",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "308"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 309,
                    "name" => "inventories_packages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "309"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 310,
                    "name" => "inventories_positions",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "310"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 311,
                    "name" => "inventories_redis_stock",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "311"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 312,
                    "name" => "inventories_statuses",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "312"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 313,
                    "name" => "inventories_stock_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "313"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 314,
                    "name" => "inventories_messages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "314"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 315,
                    "name" => "invoices_company_country_document_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "315"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 317,
                    "name" => "invoices_company_country_document_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "317"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 320,
                    "name" => "invoices_company_country_payment_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "320"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 322,
                    "name" => "invoices_company_country_payment_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "322"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 325,
                    "name" => "invoices_country_payment_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "325"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 327,
                    "name" => "invoices_country_payment_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "327"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 330,
                    "name" => "invoices_country_payment_type_fields_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "330"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 332,
                    "name" => "invoices_country_payment_type_fields_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "332"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 335,
                    "name" => "invoices_customers_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "335"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 336,
                    "name" => "invoices_customers_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "336"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 337,
                    "name" => "invoices_customers_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "337"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 338,
                    "name" => "invoices_customers_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "338"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 339,
                    "name" => "invoices_document_categories_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "339"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 341,
                    "name" => "invoices_document_categories_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "341"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 343,
                    "name" => "invoices_document_payments_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "343"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 345,
                    "name" => "invoices_document_payments_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "345"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 347,
                    "name" => "invoices_document_type_ranges_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "347"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 349,
                    "name" => "invoices_document_type_ranges_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "349"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 352,
                    "name" => "invoices_document_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "352"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 354,
                    "name" => "invoices_document_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "354"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 357,
                    "name" => "invoices_document_types_company_country_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "357"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 358,
                    "name" => "invoices_documents_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "358"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 359,
                    "name" => "invoices_documents_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "359"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 360,
                    "name" => "invoices_documents_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "360"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 361,
                    "name" => "invoices_documents_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "361"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 362,
                    "name" => "invoices_items_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "362"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 363,
                    "name" => "invoices_items_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "363"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 364,
                    "name" => "invoices_items_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "364"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 365,
                    "name" => "invoices_items_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "365"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 366,
                    "name" => "invoices_operation_cancel_document_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "366"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 367,
                    "name" => "invoices_operation_document_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "367"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 368,
                    "name" => "invoices_operation_payments_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "368"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 369,
                    "name" => "invoices_operation_print_document_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "369"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 370,
                    "name" => "invoices_operation_print_ticket_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "370"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 371,
                    "name" => "invoices_pickup_operations",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "371"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 372,
                    "name" => "invoices_shipment_operations",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "372"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 373,
                    "name" => "invoices_adjustments_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "373"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 375,
                    "name" => "invoices_adjustments_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "375"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 377,
                    "name" => "invoices_payment_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:16+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "377"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 378,
                    "name" => "invoices_payment_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "378"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 380,
                    "name" => "invoices_payment_types_company_country_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "380"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 381,
                    "name" => "invoices_payments_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "381"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 383,
                    "name" => "invoices_payments_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "383"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 385,
                    "name" => "invoices_providers_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "385"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 386,
                    "name" => "invoices_providers_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "386"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 387,
                    "name" => "invoices_providers_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "387"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 388,
                    "name" => "invoices_providers_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "388"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 391,
                    "name" => "invoices_tolerances_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "391"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 393,
                    "name" => "invoices_tolerances_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "393"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 396,
                    "name" => "supplies_company_country_supplies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "396"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 398,
                    "name" => "supplies_company_country_supplies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "398"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 401,
                    "name" => "supplies_country_supply_locations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "401"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 403,
                    "name" => "supplies_country_supply_locations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "403"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 406,
                    "name" => "supplies_company_country_supply_location_transactions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "406"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 408,
                    "name" => "supplies_company_country_supply_location_transactions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "408"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 409,
                    "name" => "supplies_supplies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "409"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 411,
                    "name" => "supplies_supplies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "411"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 413,
                    "name" => "supplies_supplies_actives_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "413"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 414,
                    "name" => "supplies_supplies_id_company_country_supply_location_transactions_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "414"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 415,
                    "name" => "supplies_supply_transaction_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "415"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 416,
                    "name" => "supplies_supply_transaction_types_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "416"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 417,
                    "name" => "supplies_supply_transaction_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "417"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 418,
                    "name" => "supplies_supply_transaction_types_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "418"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 419,
                    "name" => "supplies_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "419"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 421,
                    "name" => "supplies_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "421"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 427,
                    "name" => "lockers_cutoff_times_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "427"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 429,
                    "name" => "lockers_cutoff_times_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "429"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 433,
                    "name" => "lockers_incidents_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "433"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 434,
                    "name" => "lockers_incidents_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "434"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 437,
                    "name" => "lockers_locker_positions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "437"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 439,
                    "name" => "lockers_locker_positions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "439"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 442,
                    "name" => "lockers_locker_position_statuses_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "442"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 443,
                    "name" => "lockers_locker_position_statuses_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "443"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 446,
                    "name" => "lockers_locker_position_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "446"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 448,
                    "name" => "lockers_locker_position_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "448"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 451,
                    "name" => "lockers_locker_racks_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "451"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 453,
                    "name" => "lockers_locker_racks_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "453"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 456,
                    "name" => "lockers_locker_racks_content_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "456"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 457,
                    "name" => "lockers_operation",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "457"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 458,
                    "name" => "lockers_package_candidates_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "458"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 459,
                    "name" => "lockers_package_candidates_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "459"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 461,
                    "name" => "lockers_package_candidates_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "461"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 462,
                    "name" => "lockers_package_candidates_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "462"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 463,
                    "name" => "lockers_package_statuses_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "463"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 464,
                    "name" => "lockers_package_statuses_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "464"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 467,
                    "name" => "inventories_incidents_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "467"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 469,
                    "name" => "inventories_incidents_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "469"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 473,
                    "name" => "notifications_notifications_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "473"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 475,
                    "name" => "notifications_notifications_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:17+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "475"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 480,
                    "name" => "notifications_notifications_content",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "480"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 481,
                    "name" => "notifications_notification_statuses_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "481"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 483,
                    "name" => "notifications_notification_statuses_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "483"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 486,
                    "name" => "notifications_notification_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "486"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 488,
                    "name" => "notifications_notification_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "488"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 491,
                    "name" => "pickups_operations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "491"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 492,
                    "name" => "pickups_operations_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "492"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 493,
                    "name" => "pickups_operations_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "493"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 494,
                    "name" => "dropoffs_check_in",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "494"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 495,
                    "name" => "dropoffs_operations",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "495"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 496,
                    "name" => "dropoffs_packages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "496"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 502,
                    "name" => "catalogs_business_party_trader_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "502"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 504,
                    "name" => "catalogs_business_party_trader_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "504"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 507,
                    "name" => "catalogs_document_functions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "507"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 509,
                    "name" => "catalogs_document_functions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "509"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 512,
                    "name" => "catalogs_document_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "512"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 514,
                    "name" => "catalogs_document_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "514"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 517,
                    "name" => "catalogs_export_reasons_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "517"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 519,
                    "name" => "catalogs_export_reasons_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "519"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 522,
                    "name" => "catalogs_quantity_units_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "522"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 524,
                    "name" => "catalogs_quantity_units_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "524"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 527,
                    "name" => "catalogs_registration_number_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "527"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 529,
                    "name" => "catalogs_registration_number_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "529"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 532,
                    "name" => "catalogs_trading_transaction_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "532"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 534,
                    "name" => "catalogs_trading_transaction_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "534"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 537,
                    "name" => "services_additional_shipment_data",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "537"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 543,
                    "name" => "inventories_package_incidents_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "543"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 544,
                    "name" => "inventories_package_incidents_update",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "544"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 545,
                    "name" => "customs_criteria_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "545"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 546,
                    "name" => "customs_criteria_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "546"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 549,
                    "name" => "customs_rules_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "549"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 550,
                    "name" => "customs_rules_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "550"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 554,
                    "name" => "customs_catalogs_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "554"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 555,
                    "name" => "customs_catalogs_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "555"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 559,
                    "name" => "customs_operations",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "559"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 561,
                    "name" => "customs_catalogs_values_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "561"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 569,
                    "name" => "lockers_views_package_status_count",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "569"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 570,
                    "name" => "lockers_views_cutoff_packages",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "570"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 571,
                    "name" => "services_commercial_invoice_label",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:18+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "571"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 572,
                    "name" => "shipments_commercial_invoice_label",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "572"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 573,
                    "name" => "lockers_views_package_candidates",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "573"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 574,
                    "name" => "catalogs_identification_types_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "574"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 576,
                    "name" => "catalogs_identification_types_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "576"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 579,
                    "name" => "shipments_commercial_invoice",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "579"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 580,
                    "name" => "companies_country_reference_currencies_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "580"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 582,
                    "name" => "companies_country_reference_currencies_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "582"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 585,
                    "name" => "catalogs_management_areas_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "585"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 587,
                    "name" => "catalogs_management_areas_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "587"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 591,
                    "name" => "events_operation_events_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "591"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 592,
                    "name" => "events_queue_manager",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "592"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 593,
                    "name" => "events_statuses_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "593"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 594,
                    "name" => "events_statuses_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "594"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 596,
                    "name" => "events_events_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "596"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 597,
                    "name" => "events_events_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "597"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 599,
                    "name" => "events_actions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "599"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 600,
                    "name" => "events_actions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "600"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 602,
                    "name" => "events_event_action_statuses_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "602"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 603,
                    "name" => "events_event_action_statuses_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "603"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 608,
                    "name" => "shipments_shipments_cancellation_delete",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "608"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 609,
                    "name" => "companies_country_reference_products_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "609"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 611,
                    "name" => "companies_country_reference_products_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "611"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 613,
                    "name" => "companies_country_reference_extra_charges_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "613"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 615,
                    "name" => "companies_country_reference_extra_charges_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "615"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 623,
                    "name" => "checkpoints_operation_set_checkpoints_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "623"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 624,
                    "name" => "checkpoints_operation_get_checkpoints_post",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "624"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 625,
                    "name" => "report_cash_report_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "625"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 626,
                    "name" => "report_shipments_report_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "626"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 627,
                    "name" => "report_packages_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "627"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 628,
                    "name" => "report_operations_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "628"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 629,
                    "name" => "catalogs_shipment_descriptions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "629"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 631,
                    "name" => "catalogs_shipment_descriptions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "631"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 634,
                    "name" => "dropoffs_queue_manager_validation",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "634"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 648,
                    "name" => "reports_price_overrides_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "648"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 649,
                    "name" => "cra10_dropoff",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "649"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 650,
                    "name" => "cra10_reports",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "650"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 655,
                    "name" => "cra10_shipment_list",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "655"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 656,
                    "name" => "cra10_shipment_generate",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "656"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 657,
                    "name" => "cra10_shipment_save",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "657"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 658,
                    "name" => "cra10_shipment_manifest",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "658"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 659,
                    "name" => "cra10_shipment_cancel",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 1,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "659"
                    ],
                    "permission_type" => [
                        "id" => 1,
                        "name" => "FRONT_END",
                        "description" => "Front-end permissions to display or locked components",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.643000Z",
                        "updated_at" => "2022-09-02T18:42:10.643000Z"
                    ]
                ],
                [
                    "id" => 661,
                    "name" => "services_retail_rates",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "661"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 662,
                    "name" => "shipments_retail_rates",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "662"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 663,
                    "name" => "catalogs_questions_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "663"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 665,
                    "name" => "catalogs_questions_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-02T18:42:19+00:00",
                    "updated_at" => "2022-09-26T19:44:25+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "665"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 668,
                    "name" => "pickups_country_damaged_delivered_events_get_all",
                    "guard_name" => "api",
                    "created_at" => "2022-09-26T19:44:27+00:00",
                    "updated_at" => "2022-09-26T19:44:27+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "668"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ],
                [
                    "id" => 670,
                    "name" => "pickups_country_damaged_delivered_events_get",
                    "guard_name" => "api",
                    "created_at" => "2022-09-26T19:44:27+00:00",
                    "updated_at" => "2022-09-26T19:44:27+00:00",
                    "permission_type_id" => 2,
                    "pivot" => [
                        "role_id" => "11",
                        "permission_id" => "670"
                    ],
                    "permission_type" => [
                        "id" => 2,
                        "name" => "BACK_END",
                        "description" => "Back end permissions to use endpoints of different APIs",
                        "is_active" => true,
                        "created_at" => "2022-09-02T18:42:10.647000Z",
                        "updated_at" => "2022-09-02T18:42:10.647000Z"
                    ]
                ]
            ]
        ]
    ];

    /**
     * @return Redis
     */
    public static function getInstance(): Redis
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param RedisClientInterface $redisClient
     * @return string
     */
    public function createToken(RedisClientInterface $redisClient): string
    {
        if (!isset($this->token)) {
            $id = rand(1, 100000);
            $plainTextToken = ByteString::fromRandom(40)->toString();
            $this->token = "$id|$plainTextToken";
            $key = "security.token:{$this->token}";

            if ($redisClient->exists($key) === 0) {
                $redisClient->setex($key, 1800, self::TOKEN_DATA);
            }
        }

        return $this->token;
    }
}
