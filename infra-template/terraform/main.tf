terraform {
    required_providers {
        cloudflare = {
            source  = "cloudflare/cloudflare"
            version = "~> 4.0"
        }
    }
}

provider "cloudflare" {
    api_token = var.cloudflare_api_token
}

resource "cloudflare_record" "cname_tunnel" {
    zone_id = var.zone_id
    name    = "@"
    type    = "CNAME"
    content = "a4f2582c-b080-4240-ac2d-aad08596f97c.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_www" {
    zone_id = var.zone_id
    name    = "www"
    type    = "CNAME"
    content = "a4f2582c-b080-4240-ac2d-aad08596f97c.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_glitchtip" {
    zone_id = var.zone_id
    name    = "glitchtip"
    type    = "CNAME"
    content = "a4f2582c-b080-4240-ac2d-aad08596f97c.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_grafana" {
    zone_id = var.zone_id
    name    = "grafana"
    type    = "CNAME"
    content = "a4f2582c-b080-4240-ac2d-aad08596f97c.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_glitchtip_staging" {
    zone_id = var.zone_id
    name    = "staging-glitchtip"
    type    = "CNAME"
    content = "52bca479-4b6c-4f1c-9ae6-90a9ad48f5d0.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_grafana_staging" {
    zone_id = var.zone_id
    name    = "staging-grafana"
    type    = "CNAME"
    content = "52bca479-4b6c-4f1c-9ae6-90a9ad48f5d0.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_record" "cname_tunnel_staging" {
    zone_id = var.zone_id
    name    = "staging"
    type    = "CNAME"
    content = "52bca479-4b6c-4f1c-9ae6-90a9ad48f5d0.cfargotunnel.com"
    proxied = true
}

resource "cloudflare_page_rule" "www_redirect" {
    zone_id  = var.zone_id
    target   = "www.testcorporation.ru/*"
    priority = 1

    actions {
        forwarding_url {
            url = "https://testcorporation.ru/$1"
            status_code = 301
        }
    }
}
