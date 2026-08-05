# Native eCommerce AI Assistant

## Project Master Blueprint

### Version 2.0 (MVP)

---

# Document Information

| Item | Value |
|---|---|
| Project Name | Native eCommerce AI Assistant |
| Version | 2.0.0 (MVP) |
| Platform | WordPress + WooCommerce |
| Plugin | Native eCommerce AI Assistant V2 |
| AI Provider | OpenAI |
| AI API | OpenAI Responses API |
| Architecture | Native WordPress Plugin + AJAX + OpenAI |
| Product Data Storage | WooCommerce / WordPress post meta |
| Status | MVP Complete / Feature Frozen |
| Testing Status | Core Description + FAQ workflows verified |

---

# 1. Executive Summary

## Purpose

Native eCommerce AI Assistant Version 2.0 is a WooCommerce-focused WordPress plugin that adds AI-assisted product content generation directly inside the WooCommerce product editor.

Unlike Version 1.0's standalone content-generation workflow, Version 2.0 is designed around the native WooCommerce product-management workflow.

The primary generation modules currently implemented are:

- Product Description Generation
- Product FAQ Generation

The generated content is integrated into the WooCommerce product editing experience and can be retained when the product is updated.

---

# Business Goal

The objective of Version 2.0 is to make AI content generation part of the normal WooCommerce product workflow.

The MVP focuses on two practical tasks:

> Generate a professional product description and generate customer-focused FAQs without leaving the WooCommerce product editor.

The generated FAQ can also be rendered on the product's frontend description area.

---

# Target Users

The primary target users are:

- WooCommerce Store Owners
- eCommerce Businesses
- Digital Marketing Agencies
- Content Managers
- Store Administrators
- Freelance Developers
- AI Automation Agencies

---

# MVP Philosophy

Version 2.0 follows a strict Minimum Viable Product and Feature Freeze approach.

The objective is not to add every possible AI feature.

The objective is to make the core native WooCommerce workflow stable:

WooCommerce Product Editor

↓

AI Generator

↓

OpenAI Responses API

↓

Generated Content

↓

WooCommerce Product Data

↓

Frontend Product Display

The current MVP intentionally avoids unrelated advanced features.

---

# Core Objectives

Version 2.0 has five primary objectives.

## 1. Native WooCommerce Workflow

AI generation must happen inside the product editor rather than through a separate standalone dashboard.

---

## 2. Simple User Experience

The user should be able to generate Description and FAQ content with dedicated buttons.

---

## 3. Reuse Existing AI Infrastructure

The project continues using the existing OpenAI request, response parsing, and prompt architecture instead of introducing an unnecessary new AI stack.

---

## 4. Product Data Persistence

Generated Description and FAQ content must survive a WooCommerce product Update operation.

---

## 5. Frontend Integration

Saved FAQ content should be available on the public WooCommerce product page.

---

# Project Scope (Version 2.0)

Included:

✓ Product Description AI Generator

✓ Product FAQ AI Generator

✓ FAQ Auto Mode

✓ FAQ Custom Question Mode

✓ Product Editor Integration

✓ Description Modal

✓ FAQ Modal

✓ AJAX Generation

✓ OpenAI Responses API

✓ Prompt Builder

✓ OpenAI Response Parser

✓ Description Persistence

✓ FAQ Persistence

✓ WooCommerce Frontend FAQ Display

✓ FAQ Question / Answer Formatting

✓ Basic Validation

✓ Error Handling

✓ Settings Page

✓ OpenAI Model Selection

✓ Final MVP Testing

Not Included:

✗ SEO Generator

✗ Image Generation

✗ Bulk Generation

✗ Multi-language Generation

✗ AI History

✗ AI Settings Management Panel

✗ Usage Analytics

✗ RAG / Knowledge Base

These items are outside the Version 2.0 MVP feature freeze.

---

# Success Criteria

Version 2.0 is considered successful when:

- The plugin loads correctly.
- WooCommerce product editing works normally.
- Description generation works.
- FAQ generation works.
- FAQ Auto Mode works.
- FAQ Custom Question Mode works.
- Cancel closes the relevant modal without unwanted changes.
- Generated Description remains after product Update.
- Generated FAQ remains after product Update.
- New products can use the generators.
- Saved FAQ can be displayed on the frontend.
- FAQ is rendered as Question / Answer blocks when the expected format is present.
- Invalid required input is handled safely.
- OpenAI generation errors do not break the product editor.

Core Description and FAQ workflows have been verified during final MVP testing.

---

End of Part 1

# 2. Technology Stack & System Architecture

---

# Technology Stack

Version 2.0 is implemented as a native WordPress/WooCommerce plugin architecture.

## Frontend / WordPress

| Technology | Purpose |
|---|---|
| WordPress | CMS Platform |
| WooCommerce | eCommerce Product System |
| PHP | Plugin Development |
| HTML | Admin and frontend markup |
| CSS | Frontend FAQ presentation |
| JavaScript | Product-editor interaction and AJAX |
| WordPress Hooks | Product editor and frontend integration |
| WordPress Post Meta | Persistent Description/FAQ storage |

---

## AI Layer

| Technology | Purpose |
|---|---|
| OpenAI Responses API | AI generation |
| OpenAI model selected through plugin settings | AI content generation |
| Prompt Builder | Construct module-specific prompts |
| Response Parser | Extract generated AI content |

The plugin defines the OpenAI endpoint as:

```text
https://api.openai.com/v1/responses
```

---

# High-Level System Architecture

The application consists of four functional layers.

```text
+----------------------------------------------------+
|              WooCommerce Product Editor            |
|                                                    |
|  • Description Generator                           |
|  • FAQ Generator                                   |
|  • Modal UI                                        |
|  • Validation                                      |
|  • AJAX Request                                    |
+-------------------------+--------------------------+
                          |
                          |
                    WordPress AJAX
                          |
                          ▼
+----------------------------------------------------+
|              Native Plugin AI Layer                |
|                                                    |
|  • AJAX Handlers                                   |
|  • API Handler                                     |
|  • Prompt Builder                                  |
|  • OpenAI Client                                   |
|  • Response Parser                                 |
+-------------------------+--------------------------+
                          |
                          |
                    OpenAI Responses API
                          |
                          ▼
+----------------------------------------------------+
|                    OpenAI Model                    |
|                                                    |
|  • Understand Product Information                  |
|  • Generate Description / FAQ                      |
|  • Return AI Response                              |
+----------------------------------------------------+
                          |
                          ▼
+----------------------------------------------------+
|             WooCommerce Product Storage            |
|                                                    |
|  nea_ai_description                                |
|  nea_ai_faq                                        |
+-------------------------+--------------------------+
                          |
                          ▼
+----------------------------------------------------+
|              Public WooCommerce Product            |
|                                                    |
|  Product Description                               |
|  Frequently Asked Questions                       |
+----------------------------------------------------+
```

---

# System Workflow

## Product Description

```text
WooCommerce Product Editor

↓

Click Generate Description

↓

Description Modal

↓

Product Information

↓

JavaScript Validation

↓

WordPress AJAX

↓

nea_generate_description()

↓

AI Description Generator

↓

OpenAI Responses API

↓

Response Parser

↓

Generated Description

↓

WooCommerce Editor

↓

Hidden Description Field

↓

Product Update

↓

nea_ai_description
```

---

## Product FAQ

```text
WooCommerce Product Editor

↓

Click FAQ

↓

FAQ Modal

↓

Auto / Custom Mode

↓

Product Information

↓

Optional Custom Questions

↓

JavaScript Validation

↓

WordPress AJAX

↓

nea_generate_faq()

↓

AI FAQ Generator

↓

OpenAI Responses API

↓

Response Parser

↓

Generated FAQ

↓

Editable FAQ Output

↓

Hidden FAQ Field

↓

Product Update

↓

nea_ai_faq

↓

WooCommerce Frontend
```

---

# Architectural Principles

Version 2.0 follows several important architectural principles.

## Native WordPress Integration

The plugin works inside the existing WooCommerce product editor.

It does not replace WooCommerce's product management system.

---

## Modular PHP Structure

Responsibilities are divided across:

- Admin hooks
- Admin UI
- AI communication
- AJAX handlers
- Prompts
- Frontend rendering
- Settings

---

## JavaScript Separation

JavaScript is responsible for:

- UI interaction
- Modal behavior
- Client-side validation
- AJAX requests
- Updating visible fields
- Synchronizing hidden fields before product save

The JavaScript does not directly call OpenAI.

---

## AI Separation

OpenAI communication is kept inside the plugin's AI layer.

Prompt construction and response parsing are separated from the UI.

---

## Product Data Persistence

Generated content is synchronized into hidden fields and saved into WordPress product meta during product update.

---

# Design Decision: Existing WooCommerce Architecture

Version 2.0 intentionally keeps the existing WooCommerce/PHP architecture.

The plugin extends WooCommerce through hooks rather than replacing WooCommerce product editing.

This preserves compatibility with the native product editor workflow.

---

End of Part 2

# 3. Frontend Architecture (WordPress / WooCommerce Product Editor)

---

# Overview

The Version 2.0 frontend is integrated directly into the WooCommerce product editor.

Its responsibilities include:

- Render AI controls
- Collect product information
- Validate input
- Open and close generation modals
- Send AJAX requests
- Display generated content
- Synchronize hidden fields
- Preserve generated data during product Update

The frontend never communicates directly with OpenAI.

---

# Plugin Structure

```text
native-ecommerce-ai-assistant-v2/

├── native-ecommerce-ai-assistant.php
│
├── assets/
│   └── js/
│       └── product-editor.js
│
└── includes/
    │
    ├── admin/
    │   ├── enqueue.php
    │   ├── faq-box.php
    │   ├── product-hooks.php
    │   └── settings.php
    │
    ├── ai/
    │   ├── api-handler.php
    │   ├── openai.php
    │   └── response-parser.php
    │
    ├── ajax/
    │   └── ajax-handler.php
    │
    ├── frontend/
    │   └── frontend-product.php
    │
    └── prompts/
        ├── description-prompt.php
        └── faq-prompt.php
```

---

# File Responsibilities

## native-ecommerce-ai-assistant.php

Purpose:

Main plugin bootstrap file.

Responsibilities:

- Plugin metadata
- Security check
- Define plugin constants
- Define OpenAI API URL
- Load all required plugin files

Defined constants include:

```php
NEA_PLUGIN_VERSION
NEA_OPENAI_API_URL
```

The OpenAI endpoint is:

```text
https://api.openai.com/v1/responses
```

---

## product-hooks.php

Purpose:

Integrate AI controls and persistence into the WooCommerce product editor.

Responsibilities include:

- Render Description AI controls
- Render Description hidden field
- Register product-save behavior
- Save `nea_ai_description`
- Save `nea_ai_faq`

The file uses WooCommerce product-editor hooks and WordPress product meta storage.

---

## faq-box.php

Purpose:

Render the dedicated AI FAQ module in the product editor.

Responsibilities:

- Register the FAQ meta box
- Render FAQ Generate button
- Render hidden FAQ field
- Render saved FAQ output
- Render editable FAQ content
- Render FAQ generation modal
- Render Auto / Custom mode controls
- Render custom question fields

The registered meta box is:

```text
🤖 AI FAQ
```

The primary stored field is:

```text
nea_ai_faq
```

---

## enqueue.php

Purpose:

Load the product-editor JavaScript only on WordPress product editing screens.

It checks:

```text
post.php
post-new.php
```

and enqueues:

```text
assets/js/product-editor.js
```

The script version is based on the file modification time when available.

---

## api-handler.php

Purpose:

Provide the plugin-level AI generation functions used by the AJAX layer.

The current generation workflow includes:

```text
nea_generate_ai_description()
nea_generate_ai_faq()
```

These functions connect the AJAX request to the AI request layer.

---

## openai.php

Purpose:

Handle communication with the OpenAI Responses API.

The plugin uses:

```text
NEA_OPENAI_API_URL
```

as the configured Responses API endpoint.

---

## response-parser.php

Purpose:

Extract usable generated content from the OpenAI response.

The parser provides a consistent internal output for the Description and FAQ generation functions.

---

## description-prompt.php

Purpose:

Build the Product Description prompt.

The prompt receives product-related inputs such as:

- Product title
- Product context
- Benefits
- Tone
- Length

---

## faq-prompt.php

Purpose:

Build the FAQ prompt.

The FAQ prompt supports:

- Auto mode
- Custom question mode

The documented generated FAQ format is:

```text
Question: ...
Answer: ...
```

---

## ajax-handler.php

Purpose:

Expose WordPress AJAX actions for AI generation.

Supported actions include:

```text
nea_generate_description
nea_generate_faq
```

---

## settings.php

Purpose:

Provide the plugin's AI-related settings functionality.

The Version 2.0 project includes OpenAI model selection through the settings system.

---

## frontend-product.php

Purpose:

Display saved AI FAQ content on the public WooCommerce product page.

Responsibilities:

- Modify the WooCommerce Description tab callback
- Render the normal product long description
- Render saved AI FAQ immediately after the description
- Parse Question / Answer blocks
- Display formatted FAQ
- Provide fallback rendering when parsing does not match the expected structure

---

# Frontend Workflow

The user interaction follows this sequence.

```text
Open WooCommerce Product

↓

Enter / review product information

↓

Choose Description or FAQ

↓

Open Generator Modal

↓

Enter required information

↓

Choose generation options

↓

Generate

↓

AJAX Request

↓

Receive JSON Response

↓

Display Generated Content

↓

Edit if necessary

↓

Update Product

↓

Persist Product Meta
```

---

# User Interface Modules

Version 2.0 contains two primary AI generators.

---

## Module 1

Product Description Generator

Input:

- Product Title
- Product Context
- Benefits
- Tone
- Length

Output:

- Generated Product Description

The generated content is placed into the WooCommerce long-description editor and synchronized with the hidden description field.

---

## Module 2

Product FAQ Generator

Input:

- Product Title
- Product Information
- FAQ Mode

Optional input:

- Custom Questions

Output:

- Generated FAQ

The generated FAQ appears in the editable FAQ output area.

---

# FAQ Modes

Version 2.0 supports two FAQ generation modes.

---

## Auto Mode

The AI automatically generates customer-focused FAQs from the supplied product information.

The default UI describes Auto Mode as:

```text
Auto Generate (5 FAQs)
```

No custom questions are required.

---

## Custom Mode

The user can enter up to five custom questions through the FAQ modal.

The plugin collects non-empty questions and sends them to the FAQ generation function.

If Custom Mode is selected but no question is entered, the frontend displays:

```text
Please enter at least one custom question.
```

The AI is expected to answer the supplied questions rather than inventing unrelated questions.

---

# Validation Strategy

Validation occurs before the AJAX request is sent.

## Product Description

The product title is required.

If it is missing:

```text
Product title missing
```

---

## Product FAQ

The product title is required.

If it is missing:

```text
Product title missing
```

---

## FAQ Custom Mode

At least one custom question is required.

If none is entered:

```text
Please enter at least one custom question.
```

---

# Error Messages

The frontend handles common failure cases.

Examples include:

```text
Product title missing
```

```text
Please enter at least one custom question.
```

```text
Server error while generating FAQ.
```

```text
AI generation failed
```

```text
No FAQ generated
```

```text
No description generated
```

These prevent silent failures.

---

# AJAX Communication

Version 2.0 uses WordPress AJAX.

The browser sends:

```text
POST
```

to:

```text
ajaxurl
```

The request uses:

```text
application/x-www-form-urlencoded
```

rather than the standalone JSON REST payload architecture used by Version 1.0.

---

# Description AJAX Request

Action:

```text
nea_generate_description
```

Payload fields:

```text
product_title
product_context
benefits
tone
length
```

---

# FAQ AJAX Request

Action:

```text
nea_generate_faq
```

Payload fields:

```text
product_title
product_info
faq_mode
custom_questions
```

Custom questions are transmitted as newline-separated text.

---

# AJAX Response Contract

Description success response:

```json
{
  "success": true,
  "data": {
    "description": "Generated product description"
  }
}
```

FAQ success response:

```json
{
  "success": true,
  "data": {
    "faq": "Question: ... Answer: ..."
  }
}
```

WordPress AJAX's `wp_send_json_success()` is used by the handlers to produce these success responses.

---

# Description Editor Integration

After successful Description generation:

```text
Generated Description

↓

Hidden Description Field

↓

WooCommerce Editor

↓

TinyMCE

↓

editor.save()

↓

Product Update
```

The JavaScript updates:

```text
#content
```

and the hidden field:

```text
#nea-ai-description
```

This allows the generated content to remain synchronized with the WooCommerce product form.

---

# FAQ Editor Integration

After successful FAQ generation:

```text
Generated FAQ

↓

#nea-faq-content

↓

Editable FAQ Area

↓

#nea-ai-faq

↓

Product Update
```

The FAQ content is copied into the hidden field using:

```text
innerHTML
```

This preserves the editable HTML representation.

---

# FAQ Synchronization

The synchronization function is conceptually:

```text
Visible FAQ HTML

↓

neaFaqContent.innerHTML

↓

neaFaqField.value

↓

input/change events

↓

WordPress Product Update
```

The current JavaScript exposes:

```text
window.neaInitFaqGenerator
window.neaSyncFaqField
```

---

# Frontend Summary

Version 2.0 successfully delivers:

✓ Native WooCommerce Product Editor Integration

✓ Description Generator

✓ FAQ Generator

✓ FAQ Auto Mode

✓ FAQ Custom Mode

✓ Modal Workflow

✓ Validation

✓ AJAX Communication

✓ Editable FAQ Output

✓ Product Save Synchronization

✓ Frontend FAQ Rendering

---

End of Part 3

# 4. Backend Architecture (WordPress AI Processing Engine)

---

# Overview

Version 2.0 does not use the independent Node.js/Express backend architecture documented for Version 1.0.

Instead, the current V2 implementation keeps the AI request workflow inside the WordPress plugin.

The processing sequence is:

```text
WordPress AJAX

↓

AJAX Handler

↓

AI Generation Function

↓

Prompt Builder

↓

OpenAI Client

↓

OpenAI Responses API

↓

Response Parser

↓

AJAX JSON Response
```

This is a deliberate Version 2 architecture change from the standalone V1 backend.

---

# Backend / AI Folder Structure

```text
includes/

├── ai/
│   ├── api-handler.php
│   ├── openai.php
│   └── response-parser.php
│
├── ajax/
│   └── ajax-handler.php
│
└── prompts/
    ├── description-prompt.php
    └── faq-prompt.php
```

---

# Backend Responsibilities

| Layer | Responsibility |
|---|---|
| ajax-handler.php | Receive WordPress AJAX requests |
| api-handler.php | Coordinate AI generation |
| Prompt Files | Build module-specific prompts |
| openai.php | Communicate with OpenAI |
| response-parser.php | Extract usable AI output |
| Product Hooks | Persist generated product data |

Each component has a focused responsibility.

---

# AJAX Layer

File:

```text
includes/ajax/ajax-handler.php
```

The current AJAX actions are:

```text
wp_ajax_nea_generate_description
wp_ajax_nea_generate_faq
```

The handlers sanitize incoming values before passing them into the generation functions.

---

# Description Handler

Function:

```text
nea_generate_description()
```

Input:

```text
product_title
product_context
benefits
tone
length
```

Processing:

```text
Sanitize Input

↓

nea_generate_ai_description()

↓

Return JSON
```

Success:

```json
{
  "success": true,
  "data": {
    "description": "..."
  }
}
```

---

# FAQ Handler

Function:

```text
nea_generate_faq()
```

Input:

```text
product_title
product_info
faq_mode
custom_questions
```

Custom questions are converted from newline-separated text into an array.

Processing:

```text
Sanitize Input

↓

Split Custom Questions

↓

nea_generate_ai_faq()

↓

Return JSON
```

Success:

```json
{
  "success": true,
  "data": {
    "faq": "..."
  }
}
```

---

# AI Generation Layer

The generation layer provides module-specific functions:

```text
nea_generate_ai_description()

nea_generate_ai_faq()
```

These functions connect the sanitized AJAX input to the prompt and OpenAI processing layers.

---

# Prompt Selection

Version 2.0 uses dedicated prompt files.

```text
Description Request

↓

description-prompt.php

↓

OpenAI
```

```text
FAQ Request

↓

faq-prompt.php

↓

OpenAI
```

The current V2 project does not contain the V1 `aiService.js` / Express route / controller structure.

---

# OpenAI Integration

Version 2.0 uses the OpenAI Responses API.

Endpoint:

```text
https://api.openai.com/v1/responses
```

Request flow:

```text
Prompt

↓

OpenAI Client

↓

Responses API

↓

Selected Model

↓

Generated Output
```

The exact selected model is configurable through the plugin settings rather than being hard-coded in this specification.

---

# Response Processing

The OpenAI response is passed through the project's response parser.

The parser converts the provider response into content usable by the generation functions.

The AJAX layer then exposes the content through the WordPress JSON response.

---

# Error Handling

Version 2.0 protects the product editor from common generation failures.

Typical flow:

```text
OpenAI Failure

↓

AI Layer Error

↓

AJAX Handler

↓

JSON Failure

↓

Frontend Error Message
```

The frontend also protects against:

- HTTP request failure
- Invalid JSON response
- Empty Description response
- Empty FAQ response

---

# Backend Execution Flow

Complete Description sequence:

```text
Product Editor

↓

AJAX Request

↓

nea_generate_description()

↓

nea_generate_ai_description()

↓

Description Prompt

↓

OpenAI Responses API

↓

Response Parser

↓

Description

↓

wp_send_json_success()

↓

Product Editor
```

Complete FAQ sequence:

```text
Product Editor

↓

AJAX Request

↓

nea_generate_faq()

↓

nea_generate_ai_faq()

↓

FAQ Prompt

↓

OpenAI Responses API

↓

Response Parser

↓

FAQ

↓

wp_send_json_success()

↓

Product Editor
```

---

# Product Persistence Layer

Version 2.0 stores generated content in WordPress product meta.

Description:

```text
nea_ai_description
```

FAQ:

```text
nea_ai_faq
```

The product-save workflow checks for these submitted fields and updates the corresponding product meta.

---

# Description Persistence Flow

```text
Generated Description

↓

#nea-ai-description

↓

Product Form Submit

↓

product-hooks.php

↓

update_post_meta()

↓

nea_ai_description
```

---

# FAQ Persistence Flow

```text
Generated FAQ

↓

#nea-ai-faq

↓

Product Form Submit

↓

product-hooks.php

↓

update_post_meta()

↓

nea_ai_faq
```

---

# Frontend FAQ Rendering Flow

```text
WooCommerce Product

↓

get_post_meta()

↓

nea_ai_faq

↓

Parse Question / Answer Blocks

↓

Formatted FAQ HTML

↓

WooCommerce Description Tab
```

The parser expects:

```text
Question: ...
Answer: ...
```

and detects repeated Question / Answer blocks using a regular expression.

---

# Design Decisions

## Native AJAX Instead of Standalone REST Backend

Version 2.0 uses WordPress AJAX because the generator is embedded inside the WordPress product editor.

---

## Product Meta Storage

Description and FAQ are stored independently.

This prevents the two AI modules from being coupled to one another.

---

## Prompt Isolation

Description and FAQ prompts remain separate.

Changing one prompt does not require changing the other generator.

---

## Frontend / AI Separation

JavaScript never calls OpenAI directly.

The browser communicates with WordPress AJAX.

WordPress communicates with OpenAI.

---

# Backend Summary

Version 2.0 backend/AI layer provides:

✓ WordPress AJAX

✓ Description Generation

✓ FAQ Generation

✓ Prompt Separation

✓ OpenAI Responses API

✓ Response Parsing

✓ JSON Responses

✓ Product Meta Persistence

✓ Frontend FAQ Rendering

---

End of Part 4

# 5. Prompt Engineering

---

# Overview

Prompt Engineering is the core intelligence of the Description and FAQ modules.

Version 2.0 keeps prompts separated from UI logic and AJAX handlers.

The two current prompt modules are:

```text
prompts/

├── description-prompt.php
└── faq-prompt.php
```

---

# Prompt Architecture

| Prompt | Purpose |
|---|---|
| description-prompt.php | Generate product descriptions |
| faq-prompt.php | Generate product FAQs |

Each prompt has a single responsibility.

---

# Prompt Selection Flow

Description:

```text
Description AJAX Request

↓

AI Description Function

↓

description-prompt.php

↓

OpenAI
```

FAQ:

```text
FAQ AJAX Request

↓

AI FAQ Function

↓

faq-prompt.php

↓

OpenAI
```

Only the required prompt is used for each generation request.

---

# Product Description Prompt

Purpose:

Generate a product description from the supplied product information.

Inputs currently passed by the frontend include:

```text
product_title
product_context
benefits
tone
length
```

The frontend collects these values and passes them to:

```text
nea_generate_ai_description()
```

The prompt builder is responsible for turning these inputs into the final AI instruction.

---

# Product Description Output

The generated result is returned as:

```text
description
```

The frontend places the result into the WooCommerce long-description editor.

The user can then review or edit the content before updating the product.

---

# FAQ Prompt

Purpose:

Generate customer-focused product FAQs.

The FAQ prompt supports:

```text
Auto Mode
```

and:

```text
Custom Mode
```

The underlying prompt builder is:

```text
nea_build_faq_prompt()
```

---

# FAQ Auto Mode

Auto Mode is designed to generate five FAQs.

The prompt requests Question / Answer output.

Expected format:

```text
Question: ...
Answer: ...

Question: ...
Answer: ...
```

The output is stored as one FAQ content value.

---

# FAQ Custom Mode

Custom Mode receives user-provided questions.

The frontend collects up to five question fields:

```text
nea-question-1
nea-question-2
nea-question-3
nea-question-4
nea-question-5
```

Only non-empty questions are included in the request.

The backend receives them as:

```text
custom_questions
```

and converts the newline-separated string into an array.

The prompt then uses the supplied questions to generate the answers.

---

# FAQ Output Format

The expected output structure is:

```text
Question: Question text
Answer: Answer text
```

Repeated blocks are supported.

This format is important because the public frontend parser depends on the Question / Answer labels.

---

# Prompt Design Philosophy

The Version 2.0 prompt architecture follows these principles:

```text
Product Information

↓

Task Definition

↓

Generation Rules

↓

Output Format
```

The prompt should produce content that can be inserted directly into the WooCommerce product workflow.

---

# Prompt Constraints

The FAQ output must remain compatible with the frontend parser.

Therefore:

- Question labels must remain recognizable.
- Answer labels must remain recognizable.
- Question / Answer blocks must remain separable.
- Unnecessary introductory text should not interfere with parsing.

---

# Prompt Optimization

During V2 development, FAQ formatting was specifically tested because the generated content must work both:

1. Inside the admin editor.
2. On the public product page.

The final frontend parser supports the documented Question / Answer format.

---

# Extensibility

Future prompt modules could be added later without changing the fundamental plugin bootstrap architecture.

Potential future modules remain outside the V2 feature freeze, including:

- SEO Generator
- Image Generation
- Bulk Generation
- Multi-language Generation
- Other advanced AI workflows

No such module should be treated as part of the current V2 MVP.

---

# Summary

Prompt Engineering in Version 2.0 provides:

✓ Independent Description Prompt

✓ Independent FAQ Prompt

✓ Auto FAQ Mode

✓ Custom FAQ Mode

✓ Predictable FAQ Formatting

✓ Separation from UI logic

✓ Compatibility with frontend FAQ rendering

---

End of Part 5

# 6. API Contract & Data Flow

---

# Overview

Version 2.0 uses WordPress AJAX as the application communication layer.

The browser does not call a standalone `/api/ai/generate` REST endpoint.

Instead:

```text
WooCommerce Product Editor

↓

WordPress AJAX

↓

AI Generation Layer

↓

OpenAI Responses API

↓

WordPress JSON Response

↓

Product Editor
```

---

# AJAX Endpoints / Actions

Version 2.0 exposes two WordPress AJAX actions.

```text
nea_generate_description
```

and:

```text
nea_generate_faq
```

These are registered using:

```php
wp_ajax_nea_generate_description
wp_ajax_nea_generate_faq
```

---

# Request Lifecycle

Every generation request follows this sequence.

```text
User Input

↓

Frontend Validation

↓

Build AJAX Payload

↓

POST to ajaxurl

↓

WordPress AJAX Handler

↓

AI Generation Function

↓

Prompt Builder

↓

OpenAI Responses API

↓

Response Parser

↓

wp_send_json_success()

↓

Frontend
```

---

# Request Headers

The JavaScript sends:

```http
Content-Type: application/x-www-form-urlencoded
```

The payload is created using:

```text
URLSearchParams
```

---

# Description Request Payload

The Description generator sends:

```json
{
  "action": "nea_generate_description",
  "product_title": "...",
  "product_context": "...",
  "benefits": "...",
  "tone": "...",
  "length": "..."
}
```

The PHP handler sanitizes the incoming values before generation.

---

# FAQ Request Payload

The FAQ generator sends:

```json
{
  "action": "nea_generate_faq",
  "product_title": "...",
  "product_info": "...",
  "faq_mode": "auto",
  "custom_questions": "..."
}
```

For Custom Mode:

```text
custom_questions
```

contains newline-separated questions.

---

# Description Success Response

```json
{
  "success": true,
  "data": {
    "description": "Generated product description"
  }
}
```

The frontend reads:

```text
data.description
```

---

# FAQ Success Response

```json
{
  "success": true,
  "data": {
    "faq": "Question: ... Answer: ..."
  }
}
```

The frontend reads:

```text
data.faq
```

---

# Error Response

WordPress AJAX failure responses use the standard WordPress JSON success/error pattern.

The frontend checks:

```text
data.success
```

When false, the UI displays an error message.

---

# Data Structure

## Description Data

The Description workflow uses:

```text
Product Title
Product Context
Benefits
Tone
Length
Generated Description
```

Stored product meta:

```text
nea_ai_description
```

---

## FAQ Data

The FAQ workflow uses:

```text
Product Title
Product Information
FAQ Mode
Custom Questions
Generated FAQ
```

Stored product meta:

```text
nea_ai_faq
```

---

# Product Meta Structure

Version 2.0 intentionally stores Description and FAQ separately.

```text
WooCommerce Product
│
├── nea_ai_description
│
└── nea_ai_faq
```

This separation allows:

- Description to be updated independently.
- FAQ to be updated independently.
- FAQ to be rendered independently on the frontend.

---

# Description Data Flow

```text
Product Title

+

Product Context

+

Benefits

+

Tone

+

Length

↓

Description Prompt

↓

OpenAI

↓

Generated Description

↓

WooCommerce Editor

↓

nea_ai_description
```

---

# FAQ Data Flow

```text
Product Title

+

Product Information

+

FAQ Mode

+

Custom Questions

↓

FAQ Prompt

↓

OpenAI

↓

Question / Answer Content

↓

Editable FAQ Output

↓

nea_ai_faq
```

---

# Frontend FAQ Data Flow

```text
nea_ai_faq

↓

get_post_meta()

↓

Regex Parser

↓

Question / Answer Matches

↓

Q / A HTML

↓

WooCommerce Description Tab
```

---

# FAQ Parser Contract

The frontend parser expects the following pattern:

```text
Question: [question]
Answer: [answer]
```

The current regular expression is designed to find repeated blocks where a new `Question:` marker starts the next item.

If the saved FAQ does not match the expected structure, the frontend includes a fallback display instead of silently hiding the saved content.

---

# Communication Principles

Version 2.0 follows these communication rules.

- Browser communication uses WordPress AJAX.
- AJAX requests use form-encoded data.
- AJAX responses use WordPress JSON responses.
- OpenAI communication is server-side.
- Description and FAQ use independent actions.
- Product data is stored independently.
- FAQ formatting is part of the frontend rendering contract.

---

# Design Benefits

The Version 2.0 API/data design provides:

✓ Native WordPress integration

✓ Simple AJAX actions

✓ Separate Description and FAQ contracts

✓ Independent product meta storage

✓ Editable admin output

✓ Frontend FAQ rendering

✓ Clear data flow

---

# Summary

The API Contract in Version 2.0 is intentionally adapted to the native WordPress environment.

Instead of requiring a separate REST server, the WooCommerce product editor communicates with WordPress AJAX, which coordinates the AI generation workflow and returns structured JSON.

---

End of Part 6

# 7. Testing, Validation & MVP Completion Report

---

# Overview

Testing was performed continuously throughout the Version 2.0 development process.

Testing focused on the actual MVP workflow rather than on out-of-scope features.

The most important final tests covered:

- Description generation
- FAQ generation
- Product Update persistence
- FAQ Custom Mode
- FAQ Cancel behavior
- New Product workflow

---

# Testing Objectives

The primary objectives were:

- Verify WooCommerce product editor integration
- Verify Description generation
- Verify FAQ generation
- Verify Auto FAQ Mode
- Verify Custom FAQ Mode
- Verify product persistence
- Verify frontend FAQ rendering
- Verify Cancel behavior
- Verify validation
- Verify error handling

---

# Functional Testing

## Plugin Loading

Verified:

✓ Plugin loads successfully

✓ Product editor loads

✓ Product AI controls appear

✓ FAQ meta box appears

✓ JavaScript loads without the previously reported syntax failure

---

## Product Description Generator

Verified:

✓ Description generation works

✓ Product title can be used as generation context

✓ Generated Description appears in the WooCommerce editor

✓ Generated Description remains after Product Update

---

## Product FAQ Generator

Verified:

✓ FAQ modal opens

✓ Product information can be supplied

✓ FAQ generation works

✓ Generated FAQ appears in the admin output area

✓ FAQ can be edited

✓ FAQ remains after Product Update

---

# FAQ Auto Mode

Verified:

✓ Auto Mode can be selected

✓ FAQ generation succeeds

✓ Generated FAQ is stored

✓ Saved FAQ survives Product Update

✓ Saved FAQ is available to the frontend renderer

---

# FAQ Custom Mode

Verified:

✓ Custom Mode can be selected

✓ Custom question fields appear

✓ User questions are accepted

✓ Generated answers are returned

✓ The generated FAQ is displayed

✓ Custom question workflow functions correctly

---

# FAQ Cancel Test

Scenario:

Open FAQ generator.

Enter content.

Press Cancel.

Expected behavior:

```text
Modal closes

↓

No unintended generation

↓

No unwanted product change
```

Verified:

✓ Cancel closes the modal correctly.

---

# New Product Test

Scenario:

Create a new WooCommerce product.

Open the AI generator inside the new product.

Generate Description and FAQ.

Update the product.

Expected behavior:

```text
New Product

↓

Generate Description

↓

Generate FAQ

↓

Update Product

↓

Generated data remains
```

Verified:

✓ New product workflow functions.

---

# Product Update Persistence Test

Scenario:

Generate content.

Click WooCommerce Update.

Reload the product.

Expected behavior:

```text
Generated content remains available.
```

Verified:

✓ Description remains.

✓ FAQ remains.

---

# Description Persistence Test

The generated Description is synchronized into:

```text
nea_ai_description
```

before product update.

Verified:

✓ Product Update does not remove generated Description.

---

# FAQ Persistence Test

The generated FAQ is synchronized into:

```text
nea_ai_faq
```

before product update.

Verified:

✓ Product Update does not remove generated FAQ.

---

# Frontend FAQ Testing

Verified:

✓ Saved FAQ is read from product meta.

✓ FAQ is appended after the normal WooCommerce description.

✓ Question / Answer blocks can be parsed.

✓ Q / A labels are rendered.

✓ Answer paragraphs are formatted.

✓ Fallback output exists for unmatched formatting.

---

# Validation Testing

Verified scenarios include:

✓ Missing Product Title

✓ Empty Custom FAQ Questions

✓ Empty AI Description Response

✓ Empty AI FAQ Response

When validation fails, the generation request is stopped or the user is informed of the failure.

---

# AJAX Testing

Verified:

✓ `nea_generate_description` action works

✓ `nea_generate_faq` action works

✓ AJAX request reaches the PHP handler

✓ PHP sanitizes incoming values

✓ AI generation functions are called

✓ JSON success response reaches JavaScript

---

# OpenAI Integration Testing

Verified:

✓ OpenAI client initializes

✓ Responses API request is made

✓ AI content is returned

✓ Response parser extracts generated content

✓ Description generation succeeds

✓ FAQ generation succeeds

---

# Response Validation

Description response must contain:

```text
data.description
```

FAQ response must contain:

```text
data.faq
```

Empty output is rejected by the frontend.

---

# Error Handling Tests

## Missing Product Title

Scenario:

Product title is empty.

Expected Result:

```text
Product title missing
```

Verified:

✓ Generation does not continue normally.

---

## Empty Custom FAQ Questions

Scenario:

Custom Mode selected but no question supplied.

Expected Result:

```text
Please enter at least one custom question.
```

Verified:

✓ Request is stopped.

---

## Empty AI Response

Scenario:

AI returns empty Description or FAQ content.

Expected Result:

```text
No description generated
```

or:

```text
No FAQ generated
```

Verified:

✓ Empty output is not silently accepted.

---

## AJAX / Server Error

Scenario:

The AJAX request fails.

Expected Result:

```text
Server error while generating FAQ.
```

or the relevant generation error.

Verified:

✓ Frontend catches and displays the error.

---

# End-to-End Testing

Complete Description workflow:

```text
WooCommerce Product

↓

Description Modal

↓

User Input

↓

Validation

↓

AJAX

↓

PHP Handler

↓

AI Generation

↓

OpenAI

↓

Response Parser

↓

JSON Response

↓

WooCommerce Editor

↓

Product Update

↓

Product Meta
```

Complete FAQ workflow:

```text
WooCommerce Product

↓

FAQ Modal

↓

Auto / Custom Mode

↓

User Input

↓

Validation

↓

AJAX

↓

PHP Handler

↓

AI Generation

↓

OpenAI

↓

Response Parser

↓

JSON Response

↓

FAQ Output

↓

Product Update

↓

nea_ai_faq

↓

Frontend FAQ
```

The core workflows completed successfully during final testing.

---

# Performance Observations

Version 2.0 performance primarily depends on the OpenAI request.

Observed behavior:

✓ Normal product editor interaction remains responsive.

✓ Generation controls disable during generation.

✓ Generate buttons display a generating state.

✓ Successful responses are displayed immediately after the request completes.

---

# Known Limitations

Version 2.0 intentionally excludes:

- SEO Generator
- Image Generation
- Bulk Generation
- Multi-language Generation
- AI History
- Usage Analytics
- RAG / Knowledge Base
- Advanced AI management UI

These are not failures of the MVP.

They are deliberate Feature Freeze exclusions.

---

# MVP Completion Status

## WooCommerce Integration

✓ Complete

---

## Description Generator

✓ Complete

---

## FAQ Generator

✓ Complete

---

## FAQ Auto Mode

✓ Complete

---

## FAQ Custom Mode

✓ Complete

---

## AJAX

✓ Complete

---

## OpenAI Integration

✓ Complete

---

## Prompt Engineering

✓ Complete

---

## Product Meta Persistence

✓ Complete

---

## Frontend FAQ Rendering

✓ Complete

---

## Validation

✓ Complete

---

## Error Handling

✓ Complete

---

## Functional Testing

✓ Complete

---

## End-to-End Testing

✓ Complete

---

# Version Summary

Version:

```text
Version 2.0.0 (MVP)
```

Project Status:

```text
Feature Frozen / Core MVP Completed
```

Architecture Status:

```text
Stable
```

Deployment Readiness:

```text
Ready for MVP demonstration, client evaluation, and controlled delivery.
```

---

# Conclusion

Version 2.0 successfully transforms the AI generation workflow into a native WooCommerce product-editing experience.

The MVP provides:

- Product Description generation
- Product FAQ generation
- FAQ Auto Mode
- FAQ Custom Mode
- AJAX-based generation
- OpenAI Responses API integration
- Product meta persistence
- Frontend FAQ rendering
- Validation
- Error handling

The system keeps Description and FAQ data separate and integrates the generated content with the existing WooCommerce product workflow.

The project is intentionally kept within the Version 2.0 Feature Freeze.

---

End of Part 7

# 9. AI Reconstruction Guide (Master Blueprint)

---

## 9.1 Purpose

এই document-এর উদ্দেশ্য হলো Native eCommerce AI Assistant Version 2.0-এর সম্পূর্ণ technical blueprint সংরক্ষণ করা।

এই document ব্যবহার করতে পারবে:

- AI developer
- Human developer
- Maintenance developer
- Future project owner
- Reconstruction workflow

এর উদ্দেশ্য নতুন architecture উদ্ভাবন করা নয়।

এর উদ্দেশ্য হলো বর্তমান Version 2.0 project-এর documented behavior এবং structure faithfulভাবে পুনর্গঠন করা।

---

## 9.2 Project Vision

Native eCommerce AI Assistant Version 2.0 হলো WooCommerce-এর native product editor-এর মধ্যে AI-assisted product content generation system।

এটি মূলত দুটি MVP workflow solve করে:

1. Product Description generation
2. Product FAQ generation

FAQ generation-এর দুটি mode আছে:

- Auto
- Custom

Generated FAQ WooCommerce product-এর public Description area-তে render হতে পারে।

---

## 9.3 System Overview

পুরো architecture-এর high-level summary:

```text
WooCommerce Product Editor

↓

WordPress AJAX

↓

AI Generation Layer

↓

Prompt Builder

↓

OpenAI Responses API

↓

Response Parser

↓

Generated Content

↓

WooCommerce Product Meta

↓

Frontend Product Display
```

---

## 9.4 Project Structure

### WordPress Structure

```text
native-ecommerce-ai-assistant-v2/

├── native-ecommerce-ai-assistant.php
│
├── assets/
│   └── js/
│       └── product-editor.js
│
└── includes/
    ├── admin/
    │   ├── enqueue.php
    │   ├── faq-box.php
    │   ├── product-hooks.php
    │   └── settings.php
    │
    ├── ai/
    │   ├── api-handler.php
    │   ├── openai.php
    │   └── response-parser.php
    │
    ├── ajax/
    │   └── ajax-handler.php
    │
    ├── frontend/
    │   └── frontend-product.php
    │
    └── prompts/
        ├── description-prompt.php
        └── faq-prompt.php
```

### File Responsibility

```text
native-ecommerce-ai-assistant.php
    ↓
Bootstrap

product-hooks.php
    ↓
Product Editor Integration + Meta Save

faq-box.php
    ↓
FAQ Meta Box + UI

enqueue.php
    ↓
Admin JavaScript

product-editor.js
    ↓
Description / FAQ UI + AJAX + Save Sync

ajax-handler.php
    ↓
WordPress AJAX

api-handler.php
    ↓
AI Generation Coordination

description-prompt.php
    ↓
Description Prompt

faq-prompt.php
    ↓
FAQ Prompt

openai.php
    ↓
OpenAI Responses API

response-parser.php
    ↓
AI Response Extraction

frontend-product.php
    ↓
Public FAQ Rendering

settings.php
    ↓
AI Settings / Model Selection
```

---

## 9.5 Complete Functional Requirements

Version 2.0 must include:

✓ Product Description Generator

✓ Product FAQ Generator

✓ FAQ Auto Mode

✓ FAQ Custom Mode

✓ Product Editor Integration

✓ Description Modal

✓ FAQ Modal

✓ AJAX Generation

✓ OpenAI Responses API

✓ Prompt Builder

✓ Response Parser

✓ Description Persistence

✓ FAQ Persistence

✓ WooCommerce Frontend FAQ

✓ Validation

✓ Error Handling

✓ Product Update Compatibility

No out-of-scope feature should be added to the V2 MVP.

---

## 9.6 Module Specifications

### Description Module

Purpose:

Generate a product description inside the WooCommerce product editor.

Input:

```text
product_title
product_context
benefits
tone
length
```

Output:

```text
description
```

Storage:

```text
nea_ai_description
```

UI:

```text
Generate Description
```

---

### FAQ Module

Purpose:

Generate customer-focused FAQs.

Input:

```text
product_title
product_info
faq_mode
custom_questions
```

Output:

```text
faq
```

Storage:

```text
nea_ai_faq
```

UI:

```text
FAQ
```

Modes:

```text
Auto
Custom
```

---

### FAQ Auto Mode

Expected behavior:

```text
Product Information

↓

AI

↓

Five FAQs
```

---

### FAQ Custom Mode

Expected behavior:

```text
User Questions

↓

AI

↓

Answers for Supplied Questions
```

The frontend supports five question fields and sends only non-empty values.

---

### Persistence Module

Description:

```text
#nea-ai-description

↓

Product Update

↓

nea_ai_description
```

FAQ:

```text
#nea-ai-faq

↓

Product Update

↓

nea_ai_faq
```

---

### Frontend FAQ Module

```text
nea_ai_faq

↓

Regex Parse

↓

Question / Answer Blocks

↓

Formatted FAQ

↓

WooCommerce Description Tab
```

---

## 9.7 API Contract

### Description Action

```text
wp_ajax_nea_generate_description
```

Request:

```json
{
  "action": "nea_generate_description",
  "product_title": "...",
  "product_context": "...",
  "benefits": "...",
  "tone": "...",
  "length": "..."
}
```

Response:

```json
{
  "success": true,
  "data": {
    "description": "..."
  }
}
```

---

### FAQ Action

```text
wp_ajax_nea_generate_faq
```

Request:

```json
{
  "action": "nea_generate_faq",
  "product_title": "...",
  "product_info": "...",
  "faq_mode": "auto",
  "custom_questions": "..."
}
```

Response:

```json
{
  "success": true,
  "data": {
    "faq": "Question: ... Answer: ..."
  }
}
```

---

### Product Meta Contract

```text
nea_ai_description
```

stores the generated Description.

```text
nea_ai_faq
```

stores the generated FAQ.

These fields are independent.

---

## 9.8 Prompt Architecture

Description:

```text
Description Input

↓

description-prompt.php

↓

OpenAI
```

FAQ:

```text
FAQ Input

↓

faq-prompt.php

↓

OpenAI
```

FAQ output must remain compatible with:

```text
Question:
Answer:
```

because the public frontend parser depends on this structure.

---

## 9.9 UI Behaviour

### Description

```text
Click Generate Description

↓

Open Modal

↓

Enter Information

↓

Generate Description

↓

Button Disabled

↓

Generating State

↓

AJAX

↓

Generated Description

↓

WooCommerce Editor

↓

Modal Closes
```

---

### FAQ

```text
Click FAQ

↓

Open FAQ Modal

↓

Select Auto / Custom

↓

Enter Information

↓

Generate FAQ

↓

Button Disabled

↓

Generating State

↓

AJAX

↓

Generated FAQ

↓

Display Editable FAQ

↓

Sync Hidden Field

↓

Modal Closes
```

---

### Cancel

```text
Open Modal

↓

Enter Content

↓

Cancel

↓

Modal Closes

↓

No Generation
```

---

### Save

```text
Product Form Submit

↓

Sync Description

↓

Sync FAQ

↓

WooCommerce Update

↓

Product Meta Saved
```

---

## 9.10 Backend Behaviour

Description:

```text
AJAX Handler

↓

nea_generate_description()

↓

nea_generate_ai_description()

↓

Description Prompt

↓

OpenAI

↓

Response Parser

↓

JSON Response
```

FAQ:

```text
AJAX Handler

↓

nea_generate_faq()

↓

nea_generate_ai_faq()

↓

FAQ Prompt

↓

OpenAI

↓

Response Parser

↓

JSON Response
```

The backend/AI layer must not be moved into browser JavaScript.

---

## 9.11 Development Rules

যদি ভবিষ্যতে Version 2.0 modify করা হয়:

✓ Native WooCommerce architecture preserve করতে হবে.

✓ Description এবং FAQ আলাদা রাখতে হবে.

✓ `nea_ai_description` এবং `nea_ai_faq` আলাদা storage field হিসেবে রাখতে হবে.

✓ AJAX actions-এর documented behavior break করা যাবে না.

✓ OpenAI communication browser থেকে করা যাবে না.

✓ Prompt files আলাদা থাকবে.

✓ FAQ output format-এর Question / Answer contract break করা যাবে না.

✓ Frontend FAQ parser-এর সাথে incompatible output তৈরি করা যাবে না.

✓ Product Update workflow break করা যাবে না.

✓ Out-of-scope features Feature Freeze ভাঙবে না.

✓ Existing WooCommerce hooks অপ্রয়োজনীয়ভাবে replace করা যাবে না.

---

# Coding Principles

Follow:

- Clean architecture
- Separation of concerns
- Modular development
- Small patches
- Existing PHP architecture preservation
- Minimal dependencies
- Clear variable naming
- Safe input handling
- Predictable JSON responses

---

# Forbidden Changes

Do NOT:

- Replace WooCommerce product editing.
- Move OpenAI calls into browser JavaScript.
- Merge Description and FAQ storage.
- Remove `nea_ai_description`.
- Remove `nea_ai_faq`.
- Break FAQ Question / Answer formatting.
- Replace WordPress AJAX with an unrelated architecture without a documented requirement.
- Introduce V2-excluded features.
- Redesign the project merely because another architecture appears more modern.
- Invent undocumented business rules.

---

# Acceptable Improvements

Only when observable behavior remains unchanged.

Examples:

- Better variable names
- Cleaner formatting
- Improved comments
- Safer sanitization
- Minor code organization
- Safer error handling
- Better frontend accessibility

---

# Missing Information Policy

If documentation does not explicitly define an implementation detail:

Infer conservatively from:

- Existing V2 code
- Existing WooCommerce hooks
- Existing file structure
- Existing AJAX contract
- Existing product meta structure
- Existing prompt behavior
- Existing frontend rendering logic

Do not redesign the project because a detail is undocumented.

If a behavior cannot be established from the documented project, treat it as unspecified rather than inventing a new requirement.

---

## 9.12 Reconstruction Checklist

Before considering reconstruction complete, verify:

✓ Plugin bootstrap

✓ Plugin constants

✓ WooCommerce integration

✓ Product editor UI

✓ Description module

✓ FAQ module

✓ FAQ Auto Mode

✓ FAQ Custom Mode

✓ AJAX actions

✓ OpenAI Responses API

✓ Description Prompt

✓ FAQ Prompt

✓ Response Parser

✓ Description hidden field

✓ FAQ hidden field

✓ Product meta persistence

✓ WooCommerce frontend FAQ

✓ Question / Answer parser

✓ Validation

✓ Error handling

✓ Product Update

✓ New Product workflow

✓ Cancel behavior

✓ Final testing

---

## 9.13 Success Criteria

কখন AI বুঝবে যে reconstruction complete হয়েছে?

যখন:

✓ Plugin activates.

✓ Product editor loads.

✓ Description generator works.

✓ FAQ generator works.

✓ FAQ Auto Mode works.

✓ FAQ Custom Mode works.

✓ Cancel works.

✓ Description survives Product Update.

✓ FAQ survives Product Update.

✓ New Product workflow works.

✓ FAQ is rendered on the frontend.

✓ Question / Answer formatting remains compatible.

✓ Validation works.

✓ AJAX communication works.

✓ OpenAI communication works.

✓ Response parsing works.

✓ Product meta storage works.

✓ MVP behavior remains within Feature Freeze.

---

## 9.14 Final Instructions for AI

এই section-টা সবচেয়ে গুরুত্বপূর্ণ।

You are working with **Native eCommerce AI Assistant Version 2.0**.

Your objective is to reproduce and maintain the documented Version 2.0 project as accurately as possible.

Do not redesign the architecture.

Do not introduce unrelated frameworks.

Do not simplify documented business logic.

Preserve the native WooCommerce product workflow.

Preserve the WordPress AJAX communication model.

Preserve the OpenAI Responses API integration.

Preserve the prompt architecture.

Preserve the Description and FAQ separation.

Preserve the product meta fields.

Preserve the FAQ Question / Answer output contract.

Preserve the frontend FAQ parser.

Preserve Product Update behavior.

Preserve the Version 2.0 Feature Freeze.

If an implementation detail is missing, infer it conservatively from the existing V2 architecture and code.

Do not invent new business rules.

Do not add out-of-scope features.

The objective is faithful reconstruction and maintenance—not innovation.

---

# 9.15 AI Project Reconstruction Prompt (Golden Prompt)

## Purpose

You are tasked with reconstructing **Version 2.0 (MVP)** of the **Native eCommerce AI Assistant** project.

Your goal is not to redesign, modernize, or expand the application.

Your goal is to reproduce the current V2 project as accurately as possible using this documentation and the existing source code as the primary references.

---

# Primary Objective

Rebuild the complete V2 MVP exactly as documented.

The reconstructed application should behave like the current project in terms of:

- Architecture
- WooCommerce integration
- Features
- AJAX behavior
- AI behavior
- Prompt architecture
- Validation
- Error handling
- Product data persistence
- Frontend FAQ rendering
- User workflow
- Folder organization
- Communication flow

Do not introduce unnecessary improvements.

---

# Project Identity

Project Name:

```text
Native eCommerce AI Assistant
```

Version:

```text
2.0.0 (MVP)
```

Platform:

```text
WordPress + WooCommerce
```

Frontend:

```text
WooCommerce Product Editor
```

AI Provider:

```text
OpenAI
```

AI API:

```text
OpenAI Responses API
```

Communication:

```text
WordPress AJAX
```

Product Storage:

```text
WordPress / WooCommerce Product Meta
```

Primary Meta Fields:

```text
nea_ai_description
nea_ai_faq
```

---

# Reconstruction Scope

The reconstructed application must include:

✓ Product Description Generator

✓ Product FAQ Generator

✓ FAQ Auto Mode

✓ FAQ Custom Mode

✓ Product Editor Integration

✓ AJAX Communication

✓ OpenAI Responses API

✓ Prompt Files

✓ Response Parser

✓ Product Meta Persistence

✓ Frontend FAQ Rendering

✓ Validation

✓ Error Handling

✓ Product Update Compatibility

No V2-excluded feature should be introduced.

---

# Architectural Rules

Maintain the documented V2 architecture.

The frontend must remain inside the WooCommerce product editor.

The browser must communicate with WordPress AJAX.

The browser must never communicate directly with OpenAI.

Description and FAQ generation must remain separate.

Prompts must remain isolated.

Generated Description must remain stored as:

```text
nea_ai_description
```

Generated FAQ must remain stored as:

```text
nea_ai_faq
```

The FAQ frontend renderer must continue to recognize:

```text
Question:
Answer:
```

---

# Frontend Rules

The WordPress frontend must:

- Render AI controls
- Collect product information
- Validate input
- Open and close modals
- Send AJAX requests
- Display generated content
- Synchronize hidden fields
- Preserve content during product Update

The frontend must not:

- Call OpenAI directly
- Contain OpenAI API keys
- Generate AI content itself
- Replace WooCommerce product management

---

# AI / Backend Rules

The AI layer must:

Receive sanitized input

↓

Select the correct generator

↓

Build the correct prompt

↓

Call OpenAI

↓

Parse the response

↓

Return structured content

The AI layer must remain modular.

---

# Prompt Rules

Maintain independent prompts:

```text
description-prompt.php
faq-prompt.php
```

Description prompt:

```text
Description generation
```

FAQ prompt:

```text
FAQ generation
```

FAQ output must remain compatible with:

```text
Question:
Answer:
```

---

# API Rules

Maintain the WordPress AJAX actions:

```text
nea_generate_description
nea_generate_faq
```

Description request must support:

```text
product_title
product_context
benefits
tone
length
```

FAQ request must support:

```text
product_title
product_info
faq_mode
custom_questions
```

Successful responses must remain compatible with:

```json
{
  "success": true,
  "data": {
    "description": "..."
  }
}
```

or:

```json
{
  "success": true,
  "data": {
    "faq": "..."
  }
}
```

Do not break the documented contracts without a deliberate version change.

---

# Product Data Rules

Description storage:

```text
nea_ai_description
```

FAQ storage:

```text
nea_ai_faq
```

The two values must remain independent.

Product Update must preserve generated content.

---

# Frontend FAQ Rules

The frontend must:

1. Read `nea_ai_faq`.
2. Detect Question / Answer blocks.
3. Render Q / A labels.
4. Render answer paragraphs safely.
5. Display a fallback when the expected format is not matched.

The saved FAQ must not silently disappear merely because parsing fails.

---

# Feature Freeze Rules

Version 2.0 does not include:

- SEO Generator
- Image Generation
- Bulk Generation
- Multi-language
- AI History
- Usage Analytics
- RAG / Knowledge Base

Do not implement these features as part of the V2 MVP.

---

# Forbidden Changes

Do NOT:

- Redesign the project architecture.
- Replace WordPress AJAX without a documented requirement.
- Move OpenAI calls into JavaScript.
- Merge Description and FAQ storage.
- Change the product meta names.
- Break the FAQ Question / Answer contract.
- Remove WooCommerce integration.
- Introduce unrelated frameworks.
- Add undocumented features.
- Change business rules without documentation.

---

# Missing Information Policy

If something is not explicitly documented:

1. Inspect the existing V2 source code.
2. Follow the existing architecture.
3. Follow existing naming conventions.
4. Preserve existing observable behavior.
5. Infer conservatively.

Never redesign the project simply because another implementation would be cleaner.

---

# Final Reconstruction Objective

The reconstructed Version 2.0 must allow a user to:

```text
Open WooCommerce Product

↓

Generate Description

↓

Generate FAQ

↓

Use Auto or Custom FAQ Mode

↓

Edit generated content

↓

Update Product

↓

Reload Product

↓

Content remains

↓

Open Public Product

↓

Saved FAQ displays correctly
```

The final result must remain faithful to the Native eCommerce AI Assistant Version 2.0 MVP.

---

# Final Instruction

Treat this document as the project's official Version 2.0 technical specification.

When conflicts arise:

1. Preserve the documented V2 architecture.
2. Preserve the existing source-code behavior.
3. Preserve the documented API/data contracts.
4. Preserve Feature Freeze.
5. Infer conservatively.
6. Do not redesign.
7. Do not simplify away required behavior.
8. Do not invent undocumented features.

Your objective is:

> **Faithful reconstruction, maintenance, and controlled evolution of Native eCommerce AI Assistant Version 2.0 — not innovation beyond the documented MVP.**
