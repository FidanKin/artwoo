<x-layout.secondary.content-base :title="$artwork['name']" :$actions isViewSingleItem="{{ true }}" :canManage="$canEdit" :$backUrl>
    <x-entity.user.intro backgroundColor="white" />
    <x-widgets.lib.content-meta-info :$metaInfo />
    <x-widgets.cards.artwork-full :$artwork />
</x-layout.secondary.content-Base>
