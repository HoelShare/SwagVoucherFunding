<?php declare(strict_types=1);

namespace SwagVoucherFunding\Checkout\ProductVoucherOrder;

use Shopware\Core\Checkout\Order\Aggregate\OrderLineItem\OrderLineItemDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\PriceDefinitionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductVoucherOrderDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'product_voucher_order';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return ProductVoucherOrderCollection::class;
    }

    public function getEntityClass(): string
    {
        return ProductVoucherOrderEntity::class;
    }

    protected function getParentDefinitionClass(): ?string
    {
        return OrderLineItemDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('code', 'code'))->addFlags(new Required()),
            (new StringField('name', 'name'))->addFlags(new Required()),
            new PriceDefinitionField('value', 'value'),
            new FkField('order_line_item_id', 'orderLineItemId', OrderLineItemDefinition::class),
            new FkField('product_id', 'productId', ProductDefinition::class),
            new DateTimeField('invalidated_at', 'invalidatedAt'),

            new ManyToOneAssociationField('orderLineItem', 'order_line_item_id', OrderLineItemDefinition::class, 'id', false),
            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', false),
        ]);
    }
}
